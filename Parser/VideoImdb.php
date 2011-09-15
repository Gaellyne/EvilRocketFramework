<?php
/**
 * @desc class which working for IMDB.com
 * @author makinder
 * @version 0.0.1
 */

class Evil_Parser_VideoImdb implements   Evil_Parser_Interface
{
	/**
	 * @desc parse IMDB.com
	 * @author makinder
	 * @param string $whatWeNeed(new|top|tv);
	 * @return Array
	 * @example returned array
	 
	 array(26) {
  				[0] => array(15) 
  							{
							    ["Title"] 		=> "Drive"
							    ["Year"] 		=> "2011"
							    ["Rated"] 		=> "N/A"
							    ["Released"] 	=> "2011-05-24"
							    ["Genre"] 		=> "Action, Drama"
							    ["Director"] 	=> "Nicolas Winding Refn"
							    ["Writer"] 		=> "Hossein Amini, James Sallis"
							    ["Actors"] 		=> "Ryan Gosling, Carey Mulligan, Bryan Cranston, Christina Hendricks"
							    ["Plot"] 		=> "A Hollywood stunt performer who moonlights as a wheelman discovers that a contract has been put on him after a heist gone wrong."
							    ["Poster"] 		=> "N/A"
							    ["Runtime"] 	=> "1 hr 35 mins"
							    ["Rating"] 		=> "N/A"
							    ["Votes"] 		=> "N/A"
							    ["ID"] 			=> "tt0780504"
							    ["Response"] 	=> "True"
							  }
				}			    
	 ....................................................................................................................................
	 * @version 0.0.1
	 */
	public function parse($whatWeNeed)
	{
		switch ($whatWeNeed)
		{
			case 'new': $url = 'http://www.imdb.com/nowplaying/#topten'; break;	
			case 'top': $url = 'http://www.imdb.com/chart/';break; 
			case 'tv' : $url = 'http://www.imdb.com/search/title?num_votes=5000,&sort=user_rating,desc&title_type=tv_series';break;		
		}

 		$total_info = file_get_contents($url);
        $dom = new Zend_Dom_Query($total_info);                        
        $links = $dom->query('a');
        
        $data = array();        
        foreach ($links as $item)           	        	        
        	$data[] = $item->getAttribute('href');                	      
        
        $find = '/title/tt';
        $result = array();        
		foreach ($data as $index=>$value)
		{				
			if (strpos($value, $find) !== false)
        	{	
        		$item = substr($value, strpos($value, '/tt')+1, 9);        													        	        		
        		$result[] = $item;     		
        	}
		}		
		/*
		$request = array();
		$hoho = array_unique($result);					
		foreach ($hoho as $index=>$id)
		{												
			$requesturl = 'http://www.imdbapi.com/?t=' .$id .'&year=2011' ;
			$request[$whatWeNeed] = json_decode(file_get_contents($requesturl),true);
		}
		*/
        $requesturl = 'http://www.imdbapi.com/?t=tt0780504';
        $request = array(json_decode(file_get_contents($requesturl),true));

		foreach ($request as $index=>$mas)
            $request[$index]['Released'] = date("Y-m-d", strtotime($mas['Released']));

		return $request;				
	}
}