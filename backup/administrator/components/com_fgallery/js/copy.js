/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
  jQuery("#copypref").each(function() {
                //Create a new clipboard client
                var clip = new ZeroClipboard.Client();
                ZeroClipboard.setMoviePath(jQuery(this).attr('rel'));
                clip.glue("copypref"); 
                //Grab the text from the parent row of the icon
                var txt = '';
                jQuery('#fgallery_settings p').each(function(){
                    txt = txt + jQuery(this).text() + "\n";
                });

                clip.setText(txt);

                //Add a complete event to let the user know the text was copied
                clip.addEventListener('complete', function(client, text) {
                    alert("Settings copied successfully");
                });
            });
      jQuery("#shortcode").each(function() {
                //Create a new clipboard client
                var clip = new ZeroClipboard.Client();
                ZeroClipboard.setMoviePath(jQuery(this).attr('rel'));
                clip.glue("shortcode");
                //Grab the text from the parent row of the icon
                var txt = jQuery('#shortcode_view').text();

                clip.setText(txt);

                //Add a complete event to let the user know the text was copied
                clip.addEventListener('complete', function(client, text) {
                    alert("Now paste text from clipboard to the post");
                });
            });
});



