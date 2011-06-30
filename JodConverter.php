<?php
 /**
  * для работы необходимо установить jodconverter от openoffice, из Папки JodConverter скопировать в /etc/init.d openoffice.sh и запустить /etc/init.d/./openoffice.sh start
	-    во время работы jodconverter'а openoffice не будет работать
	-    остновить /etc/init.d/./openoffice.sh stop

  * Отправляет комманду jodconverter'у для конвертирования 
    Конвертирует:
	Text Formats
   	    $inputFileName любой формат из
		OpenDocument Text (*.odt)
		OpenOffice.org 1.0 Text (*.sxw)
		Rich Text Format (*.rtf)
		Microsoft Word (*.doc)
		WordPerfect (*.wpd)
		Plain Text (*.txt)
		HTML1 (*.html) 	Portable Document Format (*.pdf)

	    $outputFileName любой формат из
		OpenDocument Text (*.odt)
		OpenOffice.org 1.0 Text (*.sxw)
		Rich Text Format (*.rtf)
		Microsoft Word (*.doc)
		Plain Text (*.txt)
		HTML2 (*.html)
		MediaWiki wikitext (*.wiki)

	Spreadsheet Formats
   	    $inputFileName  любой формат из
		OpenDocument Spreadsheet (*.ods)
		OpenOffice.org 1.0 Spreadsheet (*.sxc)
		Microsoft Excel (*.xls)
		Comma-Separated Values (*.csv)
		Tab-Separated Values (*.tsv) 

	    $outputFileName любой формат из
		Portable Document Format (*.pdf)
		OpenDocument Spreadsheet (*.ods)
		OpenOffice.org 1.0 Spreadsheet (*.sxc)
		Microsoft Excel (*.xls)
		Comma-Separated Values (*.csv)
		Tab-Separated Values (*.tsv)
		HTML2 (*.html)

	Presentation Formats
   	    $inputFileName  любой формат из
		OpenDocument Presentation (*.odp)
		OpenOff	    $outputFileName любой формат из
ice.org 1.0 Presentation (*.sxi)
		Microsoft PowerPoint (*.ppt)

	    $outputFileName любой формат из
	 	Portable Document Format (*.pdf)
		Macromedia Flash (*.swf)
		OpenDocument Presentation (*.odp)
		OpenOffice.org 1.0 Presentation (*.sxi)
		Microsoft PowerPoint (*.ppt)
		HTML2 (*.html)

	Drawing Formats
   	    $inputFileName  любой формат из
		OpenDocument Drawing (*.odg)

	    $outputFileName любой формат из
	 	Scalable Vector Graphics (*.svg)
		Macromedia Flash (*.swf)   * @param  $inputFileName
  * @param  $outputFileName
  * @example
  *	 Evil_Avr::avr($params,'file.odt');
  *
  */
class Evil_JodConverter{
	public static function convert($inputFileName,$outputFileName){
		return shell_exec('jodconverter '.$inputFileName.' '.$outputFileName);
	}
}
?>
