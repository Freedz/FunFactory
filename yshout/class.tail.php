<?php
/**
 * The class class.tail.php
 * 
 * The tail class is for structured reading of files
 * that are continuous increasing in lines (e.g. logfiles)
 */
 	define("HIGHLIGHT_NOT",0);	# do not highlight grep-word
	define("HIGHLIGHT_SPAN",100);	# highlight with <span class="highlight">grep-word</span>
	define("HIGHLIGHT_BOLD",200);	# highlight with <b>grep-word</b>
	define("HIGHLIGHT_ASTERISK",300);	# highlight with *grep-word*
//	define("HIGHLIGHT_CUSTOM",400);	# highlight with sprintf
	
	define("PLAIN",1);	# plain output (with \n at EOL)
	define("BREAKS",2);	# a <br/ > at each EOL
	define("PARAGRAPH",4);	# split with paragraphs
	define("UL_LIST",8);	# split in an unordered list
	define("OL_LIST",16);	# split in an ordered list
	define("XML",32);	# ouput XML with <list><line>line</line></list>
//	...
 
 /**
 * @author Bastian Gorke <phpclasses@bastian.gorke.de>
 * @version 2005-12-14
 * $$Id$$
 */
class	tail
{
	/**
	 * timestamp of last modify (mtime)
	 */
	var $timestamp = 0;
	
	/**
	 * size of file
	 */
	var $filesize;
	
	/**
	 * complete filename, including path
	 */
	var $filename;
	
	/**
	 * array with seperated lines of file
	 */
	var $filearray = array();
	
	/**
	 * array with output
	 */
	var $outputarray = array();
	
	/**
	 * total number of lines
	 */
	var $lines;
	
	/**
	 * last line showed
	 */
	var $lastline;
	
	/**
	 * how many lines should be shown - defaults to 10
	 */
	var $showlines = 10;
	
	/**
	 * searchstring, might be a regular expression
	 */
	var $regexp = '';
	
	/**
	 * highlight string
	 */
	var $highlight;
		
	/**
	 * constructor for tail-class
	 * 
	 * @access public
	 * @param string filename
	 * @version 2005-12-14
	 */
	function tail($filename){
		if (file_exists($filename)) {
			$this->filename = $filename;
			$this->updatestats();
		} else
			return null;
	}
	
	/**
	 * update filesize, mtime, ...
	 * @access private
	 * @version 2005-12-15
	 */
	function updatestats(){
		$new_timestamp = filemtime($this->filename);
		
		// check for change
		if ($new_timestamp > $this->timestamp){
			$this->filesize = filesize($this->filename);
			$this->openFile();
			$this->timestamp = $new_timestamp;
		}
	}
	
	/**
	 * @access public
	 * @param integer format use defined consts to change format of output
	 * @return string the upcoming lines
	 * @version 2005-12-15
	 */
	function output($format = PLAIN){
		$highlight = "\1";
		if ($format >= HIGHLIGHT_ASTERISK) {
			$highlight = "*".$this->highlight."*";
			$format -= HIGHLIGHT_ASTERISK;
		} else if ($format >= HIGHLIGHT_BOLD) {
			$highlight = "<b>".$this->highlight."</b>";
			$format -= HIGHLIGHT_BOLD;
		} else if ($format >= HIGHLIGHT_SPAN) {
			$highlight = '<span class="highlight">'.$this->highlight.'</span>';
			$format -= HIGHLIGHT_SPAN;
		} else if ($format >= HIGHLIGHT_NOT) {
			$highlight = $this->highlight;
		}
		
		$pre_output = "";
		$post_output = "";
		$pre_line = "";
		$post_line = "\n";
		switch ($format) {
			case BREAKS:
				$pre_line = "";
				$post_line = "<br />";
				break;
			case PARAGRAPH:
				$pre_line = "<p>";
				$post_line = "</p>";
				break;
			case UL_LIST:
				$pre_output = "<ul>";
				$post_output = "</ul>";
				$pre_line = "<li>";
				$post_line = "</li>";
				break;
			case OL_LIST:
				$pre_output = "<ol>";
				$post_output = "</ol>";
				$pre_line = "<li>";
				$post_line = "</li>";
				break;
			case XML:
				// TODO check for encoding! whats linux system default?
				$pre_output = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n<list>";
				$post_output = "</list>";
				$pre_line = "<line>";
				$post_line = "</line>\n";
				break;
		
			default:
				break;
		}
		
		// TODO render output
		$output = $pre_output;
		for ($i = $this->lines - $this->showlines; $i<$this->lines; $i++){
 			if (isset($this->outputarray[$i])) {
 				// format string
 				$output .= $pre_line;
  				$output .= ($this->regexpr == '')?$this->outputarray[$i]:str_replace($this->highlight, $highlight, $this->outputarray[$i]);
  				$output .= $post_line;
 			}
		}
		$output .= $post_output;
		return $output;
	}
	
	/**
	 * search for a regular expression. highlight of searchstring is not possible, yet.
	 * 
	 * @access public
	 * @param string regexp RegExpr as searchstring (delimiter is set already). only lines containing this string are returned
	 * @version 2005-12-15
	 */
	function setGrepRegExpr($regexp){
		$this->regexpr = '~('.$regexp.')~';
		$this->doGrep();
	}

	/**
	 * search for a case-sensitive string
	 * 
	 * @access public
	 * @param string searchword a simple (single) word as searchstring. only lines containing this string are returned
	 * @version 2005-12-15
	 */
	function setGrep($searchword){
		$this->regexpr = "~.*(".$searchword.").*~i";
		$this->highlight = $searchword;
		$this->doGrep();
	}
		
	/**
	 * search for a case-INsensitive string
	 * 
	 * @access public
	 * @param string string a simple (single) word as searchstring. only lines containing this string are returned
	 * @version 2005-12-15
	 */
	function setGrepi($string){
		$this->regexpr = "~.*(".$string.").*~i";
		$this->highlight = $string;
		$this->doGrep();
	}
	
	/**
	 * open file as set in tail::filename
	 * 
	 * @access private
	 * TODO optimize for memory usage (use fopen, fseek, fgets)
	 * @version 2005-12-15
	 */
	function openFile(){
		$this->filearray = $this->outputarray = file($this->filename);
		$this->lines = count($this->filearray);
	}
	
	/**
	 * shrink lines to that containing the regexp
	 * @access private
	 * @version 2005-12-15
	 */
	function doGrep(){
		if (strlen($this->regexpr) > 3)
			$this->outputarray = preg_grep($this->regexpr,$this->filearray);
	}
	
	/**
	 * set the numbers of lines shown
	 * @access public
	 * @param integer lines the number of lines to be shown
	 * @version 2005-12-15
	 */
	function setNumberOfLines($lines){
		$this->showlines = $lines;
	}
}
?>