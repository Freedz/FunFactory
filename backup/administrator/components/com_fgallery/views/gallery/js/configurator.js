jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        jQuery(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
            return (
                key == 8 || 
                key == 9 ||
                key == 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        })
    })
};

function save_settings() {
	if (jQuery("#fgalleryName").val() == '') {
		jQuery("#fgalleryName").parent().append('<p class="error">Please enter the gallery name first<\/p>')
		jQuery("#fgalleryName").css('border','1px solid #f00');
	} else {
		jQuery("#sc-configurator-form").submit();
	}
}

function fgallery_checkform() {
	if (jQuery("#fgalleryName").val() == '') {
		jQuery("#fgalleryName").parent().append('<p class="error">Please enter the gallery name first<\/p>')
		jQuery("#fgalleryName").css('border','1px solid #f00');
		return false;
	} else {
		return true;
	}
}

jQuery(document).ready(function(){
	jQuery("#fgalleryName").click(function(){
		jQuery(this).css('border','1px solid #DFDFDF');
		jQuery('.error').remove();
	}).focus(function(){
		jQuery(this).css('border','1px solid #DFDFDF');
		jQuery('.error').remove();
	});

  jQuery(".numeric").ForceNumericOnly();	

  // jQuery UI tabs.

  jQuery(".adminform form > div").tabs();


  // jQuery UI Slider.

  jQuery(".sc-slider-val").attr('readonly', 1).after('<div class="sc-slider"></div>');
  jQuery(".sc-slider").each(function(){
    var input = jQuery(this).prev();
    var min = input.attr('min') - 0;
    var max = input.attr('max') - 0;
    var step = input.attr('step') - 0;
    var stepsCount = (max - min) / step;
    var stepSize = 100 / stepsCount;

    var initValue = input.val() - 0;
    var initStep = stepSize / step;

    var sliderOffset = 12;

    input.css('left', (initValue - min) / step * stepSize - sliderOffset);
    jQuery(this).removeAttr('slide').slider({
      value:  initValue,
      min:    min,
      max:    max,
      step:   step,
      slide:  function(event, ui){
        if ((step - Math.floor(step)) > 0.01) value = ui.value.toFixed(1);
        else value = ui.value.toFixed(0);
        if ((value - Math.floor(value)) < 0.01) value = Math.floor(value)

        input.css('left', (ui.value - min) / step * stepSize - sliderOffset).val(value);
      },
      change: function(event, ui) {
        scSetParam(input.attr('id'), ui.value);
      }
    });
  });


  // Color picker. (Farbtastic.

  jQuery("body").append("<div id='colorpicker'></div>");
  jQuery("#colorpicker").farbtastic(".sc-color-val:first").prepend("<span class='ui-icon ui-icon-check'></span>");
  jQuery('.sc-color-val').each(function(){
    jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
  });
  jQuery('.sc-color-val').focus(function() {
    jQuery("#colorpicker").hide();
    jQuery.farbtastic("#colorpicker").linkTo(jQuery(this));
    jQuery("#colorpicker").attr('old-color', jQuery.farbtastic("#colorpicker").color);
    var offset = jQuery(this).offset();
    jQuery("#colorpicker").css('left', offset.left - 68).css('top', offset.top + 20).fadeIn(400);
  });
  jQuery("#colorpicker .ui-icon-check").click(function(){
  if (jQuery("#flashcontent").length > 0)
    scSetParam(jQuery.farbtastic("#colorpicker").callback.attr('id'), jQuery.farbtastic("#colorpicker").color.replace('#', '0x'));
    jQuery("#colorpicker").hide();
  });
  jQuery('.sc-color-val').click(function(){
    jQuery("#colorpicker").attr('old-color', jQuery.farbtastic("#colorpicker").color);
    jQuery("#colorpicker").show();
  });
  jQuery('.sc-color-val').keydown(function(event) {
    // Esc.
    if (event.keyCode == 27) {scCancelColorPicker()}
    // Enter.
    if (event.keyCode == 13) {
      jQuery("#colorpicker .ui-icon-check").click();
      event.preventDefault();
    }
    // Space.
    if (event.keyCode == 32) {jQuery("#colorpicker").show();}
  });


  // Checkbox.

  jQuery("#gallery-form .form-checkbox").click(function(){
	if (jQuery(this).val() == 'true') {
		var value = jQuery(this).attr('checked') ? 'true' : 'false';
	} else {
                value = jQuery(this).attr('checked') ? 1 : 0;
	}
    scSetParam(jQuery(this).attr('id'), value);
  });


  // Select.

  jQuery("#gallery-form .form-select").change(function() {
    scSetParam(jQuery(this).attr('id'), jQuery(this).val());
  });


  // Text field.

  jQuery("#gallery-form .form-text:not(.sc-color-val)")
  .each(function() {jQuery(this).attr('old-value', jQuery(this).val());})
  .keyup(function() {
    if (jQuery(this).attr('old-value') != jQuery(this).val()) {
      jQuery(this).addClass('sc-changed');
      jQuery(this).attr('old-value', jQuery(this).val());
    }
  })
  .change(function(){
    jQuery(this).removeClass('sc-changed');
    scSetParam(jQuery(this).attr('id'), jQuery(this).val());
  })
  .keypress(function(event){
    if (event.keyCode == 13) {
      jQuery(this).change();
      event.preventDefault();
    }
  });

});


function scSetParam(inputId, val) {
if (inputId.indexOf('sc_') != -1){
	  inputId = inputId.replace('sc_', '');
	  var inputIdArr = inputId.split('__');
	  var group = inputIdArr[0];
	  var param = inputIdArr[1];

	  var M$ = navigator.appName.indexOf("Microsoft") != -1
	  var slidyMovie = (M$ ? window : document)["flashcontent"];
	  var paramValue = group + '::' + param + '==' + val;
	  slidyMovie.setProperty(paramValue);
  }
}


function scCancelColorPicker(){
  var oldColor = jQuery("#colorpicker").attr('old-color');
  if (oldColor) {
    jQuery.farbtastic("#colorpicker").setColor(oldColor);
    jQuery("#colorpicker").hide();
  }
}