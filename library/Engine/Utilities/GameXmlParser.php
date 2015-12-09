<?php
class Engine_Utilities_GameXmlParser{

	private static $_instance = null;
        public $_NFL = null;


        //Prevent any oustide instantiation of this class
	private function  __construct() { 
		
            //$this->_NFL = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nfl-shedule";
            $this->_NFL = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nfl-shedule";
            $this->_MLB = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/mlb_shedule";
            $this->_NBA = "http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/nba-shedule";
            //$this->_NHL = "http://www.goalserve.com/getfeed/17fb5ac295654f839d11dff926d707fb/hockey/nhl-shedule";
            $this->_NHL = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nhl-shedule";
	} 
	
	private function  __clone() { } //Prevent any copy of this object
	
	public static function getInstance(){
		if( !is_object(self::$_instance) )  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
		self::$_instance = new Engine_Utilities_GameXmlParser();
		return self::$_instance;
	}
        
        public function getGameLists(){
            if(func_num_args() > 0){
                $gameName = func_get_arg(0); 
                switch ($gameName) {
                    case 'NFL':
                            $client = new Zend_Http_Client($this->_NFL);      
                            $response = $client->request();
//                            $data = simplexml_load_string($response->getBody());
                            
                            $data = $this->xmlLoad($response);
                            $matchesArray = array();
                           
                            foreach ($data as $tvalue) {
                               $gameTournamentName = (string)$tvalue['name'];
                               $gameTournamentId   = (string)$tvalue['id'];
                               foreach ($tvalue as $wvalue) {
                                 $gameWeekName   = (string)$wvalue['name'];
                                 
                                         if(isset($wvalue->matches)){
                                               foreach($wvalue->matches as $matches){

                                                   $matchesDate = $matches['date'];

                                                   $matchFormatDate = strtotime(date('Y-m-d',strtotime($matches['formatted_date'])));
                                                   $matchesArray[$matchFormatDate]['match_on'] = (string)$matchesDate;
                                                   $matchesArray[$matchFormatDate]['timezone'] = (string)$matches['timezone'];
                                                   $matchesArray[$matchFormatDate]['formatted_date'] = (string)$matches['formatted_date'];
                                                   $matchesArray[$matchFormatDate]['game_tournament_name'] = $gameTournamentName;
                                                   $matchesArray[$matchFormatDate]['game_tournament_id'] = $gameTournamentId;
                                                   $matchesArray[$matchFormatDate]['game_week_name'] = $gameWeekName;

                                                   if(isset($matches->match)){
                                                       $matchesArray[$matchFormatDate]['match_count'] = count($matches->match);

                                                       $i = 0;
                                                       foreach($matches->match as $match){
                                                           
//                                                           $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['id'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['contestID'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['time'] = (string)$match['time'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['live_id'] = (string)$match['live_id'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['formatted_date'] = (string)$match['formatted_date'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['status'] = (string)$match['status'];

                                                           $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['name'] = (string)$match->hometeam['name'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['hits'] = (string)$match->hometeam['hits'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['totalscore'] = (string)$match->hometeam['totalscore'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['id'] = (string)$match->hometeam['id'];

                                                           $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['name'] = (string)$match->awayteam['name'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['hits'] = (string)$match->awayteam['hits'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['totalscore'] = (string)$match->awayteam['totalscore'];
                                                           $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['id'] = (string)$match->awayteam['id'];

                                                           $i++;
                                                       }
                                                   }

                                               }
                                           }
                               }
                            }
                                                       
                            if(isset($data->category->matches)){
                                foreach($data->category->matches as $matches){

                                    $matchesDate = $matches['date'];


                                    $matchFormatDate = strtotime(date('Y-m-d',strtotime($matches['formatted_date'])));
                                    $matchesArray[$matchFormatDate]['match_on'] = (string)$matchesDate;
                                    $matchesArray[$matchFormatDate]['timezone'] = (string)$matches['timezone'];
                                    $matchesArray[$matchFormatDate]['formatted_date'] = (string)$matches['formatted_date'];
                                    $matchesArray[$matchFormatDate]['game_category_name'] = $gameCategoryName;
                                    $matchesArray[$matchFormatDate]['game_category_id'] = $gameCategoryId;

                                    if(isset($matches->match)){
                                        $matchesArray[$matchFormatDate]['match_count'] = count($matches->match);

                                        $i = 0;
                                        foreach($matches->match as $match){
                                            $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['time'] = (string)$match['time'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['live_id'] = (string)$match['live_id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['formatted_date'] = (string)$match['formatted_date'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['status'] = (string)$match['status'];

                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['name'] = (string)$match->hometeam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['hits'] = (string)$match->hometeam['hits'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['totalscore'] = (string)$match->hometeam['totalscore'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['id'] = (string)$match->hometeam['id'];

                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['name'] = (string)$match->awayteam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['hits'] = (string)$match->awayteam['hits'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['totalscore'] = (string)$match->awayteam['totalscore'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['id'] = (string)$match->awayteam['id'];

                                            $i++;
                                        }
                                    }

                                }
                            } 
                            return $matchesArray;
                        
                        break;
                    case 'MLB':
                            $client = new Zend_Http_Client($this->_MLB);      
                            $response = $client->request();
                            //$data = simplexml_load_string($response->getBody()); 
                            if($response){
                                $data = $this->xmlLoad($response);
                            }
                            
                            $matchesArray = array();
                            if(!empty($data)){
                                $gameCategoryName = (string)$data->category['name'];
                            $gameCategoryId   = (string)$data->category['id'];
                            
                            if(isset($data->category->matches)){
                                foreach($data->category->matches as $matches){

                                    $matchesDate = $matches['date'];


                                    $matchFormatDate = strtotime(date('Y-m-d',strtotime($matches['formatted_date'])));
                                    $matchesArray[$matchFormatDate]['match_on'] = (string)$matchesDate;
                                    $matchesArray[$matchFormatDate]['timezone'] = (string)$matches['timezone'];
                                    $matchesArray[$matchFormatDate]['formatted_date'] = (string)$matches['formatted_date'];
                                    $matchesArray[$matchFormatDate]['game_category_name'] = $gameCategoryName;
                                    $matchesArray[$matchFormatDate]['game_category_id'] = $gameCategoryId;

                                    if(isset($matches->match)){
                                        $matchesArray[$matchFormatDate]['match_count'] = count($matches->match);

                                        $i = 0;
                                        foreach($matches->match as $match){
                                            
                                            $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['time'] = (string)$match['time'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['live_id'] = (string)$match['live_id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['formatted_date'] = (string)$match['formatted_date'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['status'] = (string)$match['status'];

                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['name'] = (string)$match->hometeam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in1'] = (string)$match->hometeam['in1'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in2'] = (string)$match->hometeam['in2'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in3'] = (string)$match->hometeam['in3'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in4'] = (string)$match->hometeam['in4'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in5'] = (string)$match->hometeam['in5'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in6'] = (string)$match->hometeam['in6'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in7'] = (string)$match->hometeam['in7'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in8'] = (string)$match->hometeam['in8'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['in9'] = (string)$match->hometeam['in9'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['r'] = (string)$match->hometeam['r'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['hits'] = (string)$match->hometeam['hits'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['errors'] = (string)$match->hometeam['errors'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['totalscore'] = (string)$match->hometeam['totalscore'];                                                                                        
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['id'] = (string)$match->hometeam['id'];
                                            

                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['name'] = (string)$match->awayteam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in1'] = (string)$match->awayteam['in1'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in2'] = (string)$match->awayteam['in2'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in3'] = (string)$match->awayteam['in3'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in4'] = (string)$match->awayteam['in4'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in5'] = (string)$match->awayteam['in5'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in6'] = (string)$match->awayteam['in6'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in7'] = (string)$match->awayteam['in7'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in8'] = (string)$match->awayteam['in8'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['in9'] = (string)$match->awayteam['in9'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['r'] = (string)$match->awayteam['r'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['hits'] = (string)$match->awayteam['hits'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['errors'] = (string)$match->awayteam['errors'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['totalscore'] = (string)$match->awayteam['totalscore'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['id'] = (string)$match->awayteam['id'];
                                            
                                            foreach($match->events as $events){
                                                if(isset($events->event)){

                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['team'] = (string)$events->event['team'];
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['inn'] = (string)$events->event['inn'];
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['desc'] = (string)$events->event['desc'];
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['chw'] = (string)$events->event['chw'];
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['cle'] = (string)$events->event['cle'];
                                                    
                                                    
                                                }else{
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['team'] = "";
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['inn'] = "";
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['desc'] = "";
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['chw'] = "";
                                                    $matchesArray[$matchFormatDate]['match'][$i]['event']['cle'] = "";
                                                }
                                            }
                                            
                                            $i++;
                                        }
                                    }

                                }
                            }
                            return $matchesArray;
                            }
                            
                        break;
                    case 'NBA':
                            $client = new Zend_Http_Client($this->_NBA);      
                            $response = $client->request();
//                            $data = simplexml_load_string($response->getBody());
                            $data = $this->xmlLoad($response);
                            $matchesArray = array();

                            $gameCategoryName = (string)$data['league'];
                            $gameCategoryId   = (string)$data['id'];

                            if(isset($data->matches)){
                                foreach($data->matches as $matches){

                                    $matchesDate = $matches['date'];

                                    $matchFormatDate = strtotime(date('Y-m-d',strtotime($matches['formatted_date'])));
                                    $matchesArray[$matchFormatDate]['match_on'] = (string)$matchesDate;
                                    $matchesArray[$matchFormatDate]['timezone'] = (string)$matches['timezone'];
                                    $matchesArray[$matchFormatDate]['formatted_date'] = (string)$matches['formatted_date'];
                                    $matchesArray[$matchFormatDate]['game_category_name'] = $gameCategoryName;
                                    $matchesArray[$matchFormatDate]['game_category_id'] = $gameCategoryId;

                                    if(isset($matches->match)){
                                        $matchesArray[$matchFormatDate]['match_count'] = count($matches->match);
                                        $i = 0;
                                        foreach($matches->match as $match){
                                            $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['time'] = (string)$match['time'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['formatted_date'] = (string)$match['formatted_date'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['status'] = (string)$match['status'];

                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['name'] = (string)$match->hometeam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['totalscore'] = (string)$match->hometeam['totalscore'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['id'] = (string)$match->hometeam['id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['q1'] = (string)$match->hometeam['q1'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['q2'] = (string)$match->hometeam['q2'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['q3'] = (string)$match->hometeam['q3'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['q4'] = (string)$match->hometeam['q4'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['ot'] = (string)$match->hometeam['ot'];

                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['name'] = (string)$match->awayteam['name'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['totalscore'] = (string)$match->awayteam['totalscore'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['id'] = (string)$match->awayteam['id'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['q1'] = (string)$match->awayteam['q1'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['q2'] = (string)$match->awayteam['q2'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['q3'] = (string)$match->awayteam['q3'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['q4'] = (string)$match->awayteam['q4'];
                                            $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['ot'] = (string)$match->awayteam['ot'];

                                            $i++;
                                        }
                                    }

                                }
                            }
                            return $matchesArray;
                        break;
                    case 'NHL': 
                            $client = new Zend_Http_Client($this->_NHL);      
                            $response = $client->request();
//                            $data = simplexml_load_string($response->getBody());
                            $data = $this->xmlLoad($response);  //
//                             echo "<pre>"; print_r($data); echo "</pre>";
                            $matchesArray = array();  
                            if(isset($data->matches)){ //
                                
                                foreach($data->matches as $matches){

                                    $matchDate          = (string)$matches['date'];
                                    $matchTimezone      = (string)$matches['timezone'];
                                    $matchFormattedDate = (string)$matches['formatted_date'];
                                    $gameCategoryName   = (string)$data['league'];
                                    $gameCategoryId     = (string)$data['id'];

//                                    if(strtotime($matchFormattedDate) <= strtotime(date('d.m.Y'))){

                                        $matchFormatDate = strtotime(date('Y-m-d',strtotime($matchFormattedDate)));
                                        $matchesArray[$matchFormatDate]['match_on'] = $matchDate;
                                        $matchesArray[$matchFormatDate]['timezone'] = $matchTimezone;
                                        $matchesArray[$matchFormatDate]['formatted_date'] = $matchFormattedDate;
                                        $matchesArray[$matchFormatDate]['game_category_name'] = $gameCategoryName;
                                        $matchesArray[$matchFormatDate]['game_category_id'] = $gameCategoryId;
                                        
                                       if (isset($matches->match)) {                         
                                          $matchesArray[$matchFormatDate]['match_count'] = count($matches->match);
                                          $i = 0;
                                          foreach ($matches->match as $match) {

                                              $matchesArray[$matchFormatDate]['match'][$i]['id'] = (string)$match['id'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['time'] = (string)$match['time'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['formatted_date'] = (string)$match['formatted_date'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['status'] = (string)$match['status'];

                                              $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['name'] = (string)$match->hometeam['name'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['totalscore'] = (string)$match->hometeam['totalscore'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['hometeam']['id'] = (string)$match->hometeam['id'];

                                              $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['name'] = (string)$match->awayteam['name'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['totalscore'] = (string)$match->awayteam['totalscore'];
                                              $matchesArray[$matchFormatDate]['match'][$i]['awayteam']['id'] = (string)$match->awayteam['id'];

                                              $i++;
                                          }
                                       }
//                                    }

                                }
                            }  
                            
                            
                            return $matchesArray;
                            
                        break;

                    default:
                        break;
                }
            }
        }
        
        public function getPlayerLists(){
           
            if(func_num_args() > 0){
                
                
                $gameType = func_get_arg(0);
                $teamName = func_get_arg(1);
                $abbreviation = func_get_arg(2);
                $team = func_get_arg(3);
                                
                switch ($gameType) {
                    case 'NFL':
                        $url['ari'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ari_rosters';
                        $url['atl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/atl_rosters';
                        $url['bal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/bal_rosters';
                        $url['buf'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/buf_rosters';
                        $url['car'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/car_rosters';
                        $url['chi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/chi_rosters';
                        $url['cin'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cin_rosters';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cle_rosters';
                        $url['dal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/dal_rosters';
                        $url['den'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/den_rosters';
                        $url['det'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/det_rosters';
                        $url['gb']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/gb_rosters';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/hou_rosters';
                        $url['ind'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ind_rosters';
                        $url['jac'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/jac_rosters';
                        $url['kc']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/kc_rosters';
                        $url['mia'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/mia_rosters';
                        $url['min'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/min_rosters';
                        $url['no']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/no_rosters';
                        $url['nyg'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyg_rosters';
                        $url['nyj'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyj_rosters';
                        $url['oak'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/oak_rosters';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/phi_rosters';
                        $url['pit'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/pit_rosters';
                        $url['sd'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sd_rosters';
                        $url['sea'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sea_rosters';
                        $url['sf']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sf_rosters';
                        $url['stl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/stl_rosters';
                        $url['tb']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/tb_rosters';
                        $url['ten'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ten_rosters';    
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/wsh_rosters'; 
                        $url['ne']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ne_rosters';
                         $playerListArray = array();
                         
                         foreach ($url as $ukey => $uvalue) {
                             
                             if(is_array($teamName) && !empty($teamName)){
                                 
                                 if(array_search($ukey, $teamName)){
                                     
                                        $client = new Zend_Http_Client($uvalue);      
                                        $response = $client->request();
                                        //$data = simplexml_load_string($response->getBody());
                                        $data = $this->xmlLoad($response);
                                        foreach ($data as $dkey => $dvalue) {
                                            foreach ($dvalue as $pkey => $pvalue) {
                                                $playervalue['number']           = ((string)$pvalue['number']);
                                                $playervalue['name']             = ((string)$pvalue['name']);
                                                $playervalue['position']         = ((string)$pvalue['position']);
                                                $playervalue['age']              = ((string)$pvalue['age']);
                                                $playervalue['height']           = ((string)$pvalue['height']);
                                                $playervalue['weight']           = ((string)$pvalue['weight']);
                                                $playervalue['experience_years'] = ((string)$pvalue['experience_years']);
                                                $playervalue['college']          = ((string)$pvalue['college']);
                                                $playervalue['id']               = ((string)$pvalue['id']);
                                                $playervalue['team_name']        = ((string)$data['name']);
                                                $playervalue['team_id']          = (string) $data['id'];
                                                // get first character of words in given string to create possition code
                                               
                                                $words = explode(" ", (string)$dvalue['name']);
                                                $acronym = "";
                                                foreach ($words as $w) {
                                                    $acronym .= $w[0];
                                                }                                            
                                                $playervalue['pos_code']        = $acronym;

                                                // create team name code

                                                $team_code = array_search((string)$data['name'], $abbreviation);
                                                $playervalue['team_code'] = $team_code;
                                            
                                                // add competitor team code
                                                $playervalue['team_vs'] = $team[$team_code];
                                                
                                                array_push($playerListArray, $playervalue);
                                            }
                                        } 
                                 }
                             }                             
                         }
                         
                         if(!empty($playerListArray)){
                             $playerListArray = array_values($playerListArray);
                             return $playerListArray;
                         }
                         
                           
                        break;
                    case 'MLB':
                        
                        $url['ari'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/ari_rosters';
                        $url['atl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/atl_rosters';
                        $url['bal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/bal_rosters';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/bos_rosters';
                        $url['chc'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/chc_rosters';
                        $url['chw'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/chw_rosters';
                        $url['cin'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/cin_rosters';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/cle_rosters';
                        $url['col'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/col_rosters';
                        $url['det'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/det_rosters';
                        $url['fla'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/fla_rosters';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/hou_rosters'; 
                        $url['kan']    = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/kan_rosters';
                        //$url['KC']  = '';
                        $url['laa'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/laa_rosters';
                        $url['lad'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/lad_rosters';
                        //$url['Mia'] = '';
                        $url['mil'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/mil_rosters';
                        $url['min'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/min_rosters';
                        $url['nym'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/nym_rosters';
                        $url['nyy'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/nyy_rosters';
                        $url['oak'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/oak_rosters';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/phi_rosters';
                        $url['pit'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/pit_rosters';
                        //$url['SD']  = '';
                        //$url['SF']  = '';
                        $url['sdg'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/sdg_rosters';
                        $url['sea'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/sea_rosters';
                        $url['sfo'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/sfo_rosters';
                        $url['stl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/stl_rosters';
                        //$url['TB']  = '';
                        $url['tam'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/tam_rosters';
                        $url['tex'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/tex_rosters';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/tor_rosters';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/baseball/was_rosters';
        
                         $playerListArray = array();
                         
                         foreach ($url as $ukey => $uvalue) {
                             
                             if(is_array($teamName) && !empty($teamName)){
                                 
                                 //if(array_search($ukey, $teamName)){
                                  if(in_array($ukey, $teamName)){  
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());
                                      $data = $this->xmlLoad($response);
//                                    print"<pre>";print_r($data);print"</pre>";die;
                                    foreach ($data as $dkey => $dvalue) {
//                                        echo "<br/><br/> dvalue ---------------------------------------<br/><br/>";
//                                        print"<pre>";print_r($dvalue);print"</pre>";
                                        foreach ($dvalue as $pkey => $pvalue) {
//                                            echo "<br/><br/> pvalue ---------------------------------------<br/><br/>";
//                                            print"<pre>";print_r($pvalue);print"</pre>";die;
                                            $playervalue['number']      = (string) $pvalue['number'];
                                            $playervalue['name']        = ((string) $pvalue['name']);
                                            $playervalue['position']    = ((string) $pvalue['position']);
                                            $playervalue['bats']        = ((string) $pvalue['bats']);
                                            $playervalue['throws']      = ((string) $pvalue['throws']);
                                            $playervalue['age']         = ((string) $pvalue['age']);
                                            $playervalue['height']      = ((string) $pvalue['height']);
                                            $playervalue['weight']      = ((string) $pvalue['weight']);
                                            $playervalue['id']          = (string) $pvalue['id'];
                                            $playervalue['team_name']   = ((string) $data['name']);
                                            $playervalue['position_name'] = ((string) $dvalue['name']);
                                            $playervalue['team_id']   = (string) $data['id'];
                                            //$playervalue['pos_code']    = (string) $pvalue['position'];
                                            // get first character of words in given string to create possition code
                                               
                                            $words = explode(" ", (string)$dvalue['name']);
                                            $acronym = "";
                                            foreach ($words as $w) {
                                                $acronym .= $w[0];
                                            }                             
                                            if($acronym == 'O'){
                                                $playervalue['pos_code']        = 'OF';
                                            }else if((string) $pvalue['position'] == '1B'){
                                                $playervalue['pos_code']        = '1B';
                                            }else if((string) $pvalue['position'] == '2B'){
                                                $playervalue['pos_code']        = '2B';
                                            }else if((string) $pvalue['position'] == '3B'){
                                                $playervalue['pos_code']        = '3B';
                                            }else if((string) $pvalue['position'] == 'SS'){
                                                $playervalue['pos_code']        = 'SS';
                                            }else if(strpos((string) $pvalue['position'], 'P')){
                                                    $playervalue['pos_code']  = 'P';
                                            }else{
                                                $playervalue['pos_code']        = $acronym;
                                            }
                                            
                                            
                                            // create team name code
                                            $team_code = array_search((string)$data['name'], $abbreviation);
                                            $playervalue['team_code'] = $team_code;
                                            
                                            // add competitor team code
                                            if(isset($team[$team_code])){
                                                $playervalue['team_vs'] = $team[$team_code];
                                            }else{
                                                $playervalue['team_vs'] = "";
                                            }
                                            
                                            
                                            array_push($playerListArray, $playervalue);
                                        }
                                    }  
                                 }
                             }
//                             echo "<pre>"; print_r($playerListArray); echo "</pre>"; die;
                                                       
                         }
                         if(!empty($playerListArray)){
                             $playerListArray = array_values($playerListArray);
//                             print"<pre>";print_r($playerListArray);print"</pre>";die;
                             return $playerListArray;
                         }
                             
                        break;
                    case 'NBA':
                      

                        $url['atl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/atl_rosters';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/bos_rosters';
//                        $url['Bkn'] = '';
                        $url['cha'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cha_rosters';
                        $url['chi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/chi_rosters';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cle_rosters';
                        $url['dal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/dal_rosters';
                        $url['den'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/den_rosters';
                        $url['det'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/det_rosters';
                        $url['gs'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/gs_rosters';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/hou_rosters';
                        $url['ind'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ind_rosters';
                        $url['lac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lac_rosters';
                        $url['lal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lal_rosters';
                        $url['mem'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mem_rosters';
                        $url['mia'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mia_rosters';
                        $url['mil'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mil_rosters';
                        $url['min'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/min_rosters';
                        $url['nj'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/nj_rosters';
                        $url['no'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/no_rosters';
                        $url['ny'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ny_rosters';
                        $url['okc'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/okc_rosters';
                        $url['orl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/orl_rosters';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phi_rosters';
                        $url['phx'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phx_rosters';
                        $url['por'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/por_rosters';
                        $url['sac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sac_rosters';
                        $url['sa'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sa_rosters';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/tor_rosters';
                        $url['uta'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/utah_rosters';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/wsh_rosters';
                        
                        
                         $playerListArray = array();
                         
                         foreach ($url as $ukey => $uvalue) {
                             
                             if(is_array($teamName) && !empty($teamName)){
                                 
                                 //if(array_search($ukey, $teamName)){
                                  if(in_array($ukey, $teamName)){  
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());
                                    $data = $this->xmlLoad($response);
//                              print"<pre>";print_r($data);print"</pre>"; 
                                    foreach ($data as $dkey => $pvalue) {
//                                        echo "<br/><br/> dvalue ---------------------------------------<br/><br/>";
//                                        print"<pre>";print_r($pvalue);print"</pre>"; die;
//                                        foreach ($dvalue as $pkey => $pvalue) {
//                                            echo "<br/><br/> pvalue ---------------------------------------<br/><br/>";
//                                            print"<pre>";print_r($pvalue);print"</pre>";die;
                                        $playervalue['number']      = (string) $pvalue['number'];
                                        $playervalue['name']        = ((string) $pvalue['name']);
                                        $playervalue['position']    = ((string) $pvalue['position']);
//                                        $playervalue['bats']        = (string) $pvalue['bats'];
//                                        $playervalue['throws']      = (string) $pvalue['throws'];
                                        $playervalue['college']     = ((string) $pvalue['college']);
                                        $playervalue['age']         = ((string) $pvalue['age']);
                                        $playervalue['height']      = ((string) $pvalue['height']);
                                        $playervalue['weight']      = ((string) $pvalue['weight']);
                                        $playervalue['id']          = (string) $pvalue['id'];
                                        $playervalue['team_name']   = ((string) $data['name']);
                                        $playervalue['team_id']     = (string) $data['id'];
                                   //    print"<pre>";print_r($playervalue);print"</pre>";          
                                            // get first character of words in given string to create possition code
                                               
                                            $words = explode(" ", (string)$data['name']);
                                            $acronym = "";
                                            foreach ($words as $w) {
                                                $acronym .= $w[0];
                                            }                                            
                                            $playervalue['pos_code']        = (string) $pvalue['position'];
                                            
                                            // create team name code
                                            $team_code = array_search((string)$data['name'], $abbreviation);
                                            $playervalue['team_code'] = $team_code;
                                            
                                            // add competitor team code
                                            if(isset($team[$team_code])){
                                                $playervalue['team_vs'] = $team[$team_code];
                                            }else{
                                                $playervalue['team_vs'] = "";
                                            }
                                            
                                            
                                            array_push($playerListArray, $playervalue);
//                                        }
                                    }  
                                 }
                             }
                      //    print"<pre>";print_r($playerListArray);print"</pre>";                            
                         }
                        
                        
                         
                         if(!empty($playerListArray)){
                             $playerListArray = array_values($playerListArray);
                         //    print"<pre>";print_r($playerListArray);print"</pre>";die;
                             return $playerListArray;
                         }                        
                        
                        
                        
                        
                        break;
                    case 'NHL':
                                $url['ana'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ana_rosters';
                                $url['atl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/atl_rosters';
                                $url['bos'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/bos_rosters';
                                $url['buf'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/buf_rosters';
                                $url['car'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/car_rosters';
                                $url['cbs'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cbj_rosters';
                                $url['cgy'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cgy_rosters';
                                $url['chi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/chi_rosters';
                                $url['col'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/col_rosters';
                                $url['dal'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/dal_rosters';
                                $url['det'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/det_rosters';
                                $url['edm'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/edm_rosters';
                                $url['fla'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/fla_rosters';
                                $url['la']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/la_rosters';
                                $url['min'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/min_rosters';
                                $url['mtl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/mtl_rosters';
                                $url['nj']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nj_rosters';
                                $url['nsh'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nsh_rosters';
                                $url['nyi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyi_rosters';
                                $url['nyr'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyr_rosters';
                                $url['ott'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ott_rosters';
                                $url['phi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phi_rosters';
                                $url['phx'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phx_rosters';
                                $url['pit'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/pit_rosters';
                                $url['sj']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/sj_rosters';
                                $url['stl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/stl_rosters';
                                $url['tb']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tb_rosters';
                                $url['tor'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tor_rosters';
                                $url['van'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/van_rosters';
                                $url['wsh'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/wsh_rosters'; 
                        
                         $playerListArray = array();
                         
                         foreach ($url as $ukey => $uvalue) {
                             
                             if(is_array($teamName) && !empty($teamName)){
                                 
                                  if(in_array($ukey, $teamName)){  
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());
                                    $data = $this->xmlLoad($response);
                                    foreach ($data as $dkey => $dvalue) {

                                        foreach ($dvalue as $pkey => $pvalue) {
                                            $playervalue['number']           = (string)$pvalue['number'];
                                            $playervalue['name']             = ((string)$pvalue['name']);
                                            $playervalue['position']         = ((string)$dvalue['name']);
                                            $playervalue['age']              = ((string)$pvalue['age']);
                                            $playervalue['height']           = ((string)$pvalue['height']);
                                            $playervalue['weight']           = ((string)$pvalue['weight']);
                                            $playervalue['birth_place']      = ((string)$pvalue['birth_place']);
                                            $playervalue['shot']             = ((string)$pvalue['shot']);
                                            $playervalue['id']               = (string)$pvalue['id'];
                                            $playervalue['team_name']        = ((string)$data['name']);
                                            $playervalue['team_id']          = (string) $data['id'];
                                            // get first character of words in given string to create possition code
                                               
                                            $words = explode(" ", (string)$dvalue['name']);
                                            $acronym = "";
                                            foreach ($words as $w) {
                                                $acronym .= $w[0];
                                            }                                            
                                            $playervalue['pos_code']        = $acronym;
                                            
                                            // create team name code
                                            $team_code = array_search((string)$data['name'], $abbreviation);
                                            $playervalue['team_code'] = $team_code;
                                            
                                            // add competitor team code
                                            if(isset($team[$team_code])){
                                                $playervalue['team_vs'] = $team[$team_code];
                                            }else{
                                                $playervalue['team_vs'] = "";
                                            }
                                            
                                            
                                            array_push($playerListArray, $playervalue);
                                        }
                                    }  
                                 }
                             }
                                                       
                         }
                         
                         if(!empty($playerListArray)){
                             $playerListArray = array_values($playerListArray);
                             return $playerListArray;
                         }
                        break;                    

                    default:
                        break;
                }
            }
        }

        /**
         * Desc : Filter Array by searchkey and searchvalue
         * @param <String> $searchValue
         * @param <Array> $array
         * @param <String> $searchKey
         * @return <Array> $filtered
         */
        public function filterArray($searchValue,$array,$searchKey){
            if($searchValue != "" && $searchKey != ""){
                $filter = function($array) use($searchValue,$searchKey) { if($array[$searchKey]){return $array[$searchKey] == $searchValue;} };       
                $filtered = array_filter($array, $filter);     
                return $filtered;
            }
        }

    public function getPlayerStats(){
            
            if(func_num_args() > 0){
                
                
                $gameType = func_get_arg(0);
                                
                switch ($gameType) {
                    /**
                    * Developer    : Vivek Chaudhari
                    * Description  : get NFL game Players stats
                    * Date         : 28/08/2014
                    * @return      : <array> player stats details
                    */
                    case 'NFL' : {
                        $url['ari'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ari_player_stats';
                        $url['atl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/atl_player_stats';
                        $url['bal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/bal_player_stats';
                        $url['buf'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/buf_player_stats';
                        $url['car'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/car_player_stats';
                        $url['chi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/chi_player_stats';
                        $url['cin'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cin_player_stats';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cle_player_stats';
                        $url['dal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/dal_player_stats';
                        $url['den'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/den_player_stats';
                        $url['det'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/det_player_stats';
                        $url['gb']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/gb_player_stats';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/hou_player_stats';
                        $url['ind'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ind_player_stats';
                        $url['jac'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/jac_player_stats';
                        $url['kc']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/kc_player_stats';
                        $url['mia'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/mia_player_stats';
                        $url['min'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/min_player_stats';
                        $url['ne']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ne_player_stats';
                        $url['no']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/no_player_stats';
                        $url['nyg'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyg_player_stats';
                        $url['nyj'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyj_player_stats';
                        $url['oak'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/oak_player_stats';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/phi_player_stats';
                        $url['pit'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/pit_player_stats';
                        $url['sd']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sd_player_stats';
                        $url['sea'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sea_player_stats';
                        $url['sf']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sf_player_stats';
                        $url['stl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/stl_player_stats';
                        $url['tb']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/tb_player_stats';
                        $url['ten'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ten_player_stats';    
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/wsh_player_stats'; 
//                       
                           $playerStatsArray = array();
                           $playervalue = array();  
                         foreach ($url as $ukey => $uvalue) {
                                
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());   
                                    $data = $this->xmlLoad($response); 
                                    $i = 0;  
                                    $playerStatsArray['team'] = (string)$data['team'];
                                    $playerStatsArray['id'] = (string)$data['id'];
                                    foreach($data as $dkey=>$dvalue){ 
                                        $playerStatsArray['category'][$i]['name']= (string)$dvalue['name'];
                                        $j=0;
                                        if((string)$dvalue['name'] == 'Passing'){
                                        foreach($dvalue as $pkey=>$pvalue){ 
                                            $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                            $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                            $playerStatsArray['category'][$i]['player'][$j]['passing_attempts'] = (string)$pvalue['passing_attempts'];
                                            $playerStatsArray['category'][$i]['player'][$j]['completions'] = (string)$pvalue['completions'];
                                            $playerStatsArray['category'][$i]['player'][$j]['completion_pct'] = (string)$pvalue['completion_pct'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards'] = (string)$pvalue['yards'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards_per_pass_avg'] = (string)$pvalue['yards_per_pass_avg'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards_per_game'] = (string)$pvalue['yards_per_game'];
                                            $playerStatsArray['category'][$i]['player'][$j]['longest_pass'] = (string)$pvalue['longest_pass'];
                                            $playerStatsArray['category'][$i]['player'][$j]['passing_touchdowns'] = (string)$pvalue['passing_touchdowns'];
                                            $playerStatsArray['category'][$i]['player'][$j]['passing_touchdowns_pct'] = (string)$pvalue['passing_touchdowns_pct'];
                                            $playerStatsArray['category'][$i]['player'][$j]['interceptions'] = (string)$pvalue['interceptions'];
                                            $playerStatsArray['category'][$i]['player'][$j]['interceptions_pct'] = (string)$pvalue['interceptions_pct'];
                                            $playerStatsArray['category'][$i]['player'][$j]['sacks'] = (string)$pvalue['sacks'];
                                            $playerStatsArray['category'][$i]['player'][$j]['sacked_yards_lost'] = (string)$pvalue['sacked_yards_lost'];
                                            $playerStatsArray['category'][$i]['player'][$j]['quaterback_rating'] = (string)$pvalue['quaterback_rating'];
                                            $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                            $j++;   
                                           }
                                        }
                                        
                                        if((string)$dvalue['name'] == 'Rushing'){
                                        foreach($dvalue as $pkey=>$pvalue){ 
                                            $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                            $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                            $playerStatsArray['category'][$i]['player'][$j]['rushing_attempts'] = (string)$pvalue['rushing_attempts'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards'] = (string)$pvalue['yards'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards_per_rush_avg'] = (string)$pvalue['yards_per_rush_avg'];
                                            $playerStatsArray['category'][$i]['player'][$j]['longest_rush'] = (string)$pvalue['longest_rush'];
                                            $playerStatsArray['category'][$i]['player'][$j]['over_20_yards'] = (string)$pvalue['over_20_yards'];
                                            $playerStatsArray['category'][$i]['player'][$j]['rushing_touchdowns'] = (string)$pvalue['rushing_touchdowns'];
                                            $playerStatsArray['category'][$i]['player'][$j]['yards_per_game'] = (string)$pvalue['yards_per_game'];
                                            $playerStatsArray['category'][$i]['player'][$j]['fumbles'] = (string)$pvalue['fumbles'];
                                            $playerStatsArray['category'][$i]['player'][$j]['fumbles_lost'] = (string)$pvalue['fumbles_lost'];
                                            $playerStatsArray['category'][$i]['player'][$j]['rushing_first_downs'] = (string)$pvalue['rushing_first_downs'];
                                            $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                            $j++;   
                                           }
                                        }
                                        
                                          if((string)$dvalue['name'] == 'Receiving'){
                                            foreach($dvalue as $pkey=>$pvalue){ 
                                                $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receptions'] = (string)$pvalue['receptions'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receiving_targets'] = (string)$pvalue['receiving_targets'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receiving_yards'] = (string)$pvalue['receiving_yards'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_per_reception_avg'] = (string)$pvalue['yards_per_reception_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receiving_touchdowns'] = (string)$pvalue['receiving_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['longest_reception'] = (string)$pvalue['longest_reception'];
                                                $playerStatsArray['category'][$i]['player'][$j]['over_20_yards'] = (string)$pvalue['over_20_yards'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_per_game'] = (string)$pvalue['yards_per_game'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fumbles'] = (string)$pvalue['fumbles'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fumbles_lost'] = (string)$pvalue['fumbles_lost'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_after_catch'] = (string)$pvalue['yards_after_catch'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receiving_first_downs'] = (string)$pvalue['receiving_first_downs'];
                                                $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                $j++;   
                                               }
                                            }
                                            
                                            if((string)$dvalue['name'] == 'Defense'){
                                            foreach($dvalue as $pkey=>$pvalue){ 
                                                $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                $playerStatsArray['category'][$i]['player'][$j]['unassisted_tackles'] = (string)$pvalue['unassisted_tackles'];
                                                $playerStatsArray['category'][$i]['player'][$j]['assisted_tackles'] = (string)$pvalue['assisted_tackles'];
                                                $playerStatsArray['category'][$i]['player'][$j]['total_tackles'] = (string)$pvalue['total_tackles'];
                                                $playerStatsArray['category'][$i]['player'][$j]['sacks'] = (string)$pvalue['sacks'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_lost_on_sack'] = (string)$pvalue['yards_lost_on_sack'];
                                                $playerStatsArray['category'][$i]['player'][$j]['tackles_for_loss'] = (string)$pvalue['tackles_for_loss'];
                                                $playerStatsArray['category'][$i]['player'][$j]['passes_defended'] = (string)$pvalue['passes_defended'];
                                                $playerStatsArray['category'][$i]['player'][$j]['interceptions'] = (string)$pvalue['interceptions'];
                                                $playerStatsArray['category'][$i]['player'][$j]['intercepted_returned_yards'] = (string)$pvalue['intercepted_returned_yards'];
                                                $playerStatsArray['category'][$i]['player'][$j]['longest_interception_return'] = (string)$pvalue['longest_interception_return'];
                                                $playerStatsArray['category'][$i]['player'][$j]['interceptions_returned_for_touchdowns'] = (string)$pvalue['interceptions_returned_for_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['forced_fumbles'] = (string)$pvalue['forced_fumbles'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fumbles_recovered'] = (string)$pvalue['fumbles_recovered'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fumbles_returned_for_touchdowns'] = (string)$pvalue['fumbles_returned_for_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['blocked_kicks'] = (string)$pvalue['blocked_kicks'];
                                                $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                $j++;   
                                               }
                                            }
                                            
                                            if((string)$dvalue['name'] == 'Scoring'){
                                            foreach($dvalue as $pkey=>$pvalue){ 
                                                $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                $playerStatsArray['category'][$i]['player'][$j]['rushing_touchdowns'] = (string)$pvalue['rushing_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['receiving_touchdowns'] = (string)$pvalue['receiving_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['return_touchdowns'] = (string)$pvalue['return_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['total_touchdowns'] = (string)$pvalue['total_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['field_goals'] = (string)$pvalue['field_goals'];
                                                $playerStatsArray['category'][$i]['player'][$j]['extra_points'] = (string)$pvalue['extra_points'];
                                                $playerStatsArray['category'][$i]['player'][$j]['two_point_conversions'] = (string)$pvalue['two_point_conversions'];
                                                $playerStatsArray['category'][$i]['player'][$j]['total_points'] = (string)$pvalue['total_points'];
                                                $playerStatsArray['category'][$i]['player'][$j]['total_points_per_game'] = (string)$pvalue['total_points_per_game'];
                                                $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                $j++;   
                                               }
                                            }
                                            
                                            if((string)$dvalue['name'] == 'Returning'){
                                            foreach($dvalue as $pkey=>$pvalue){ 
                                                $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                $playerStatsArray['category'][$i]['player'][$j]['kickoff_returned_attempts'] = (string)$pvalue['kickoff_returned_attempts'];
                                                $playerStatsArray['category'][$i]['player'][$j]['kickoff_return_yards'] = (string)$pvalue['kickoff_return_yards'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_per_kickoff_avg'] = (string)$pvalue['yards_per_kickoff_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['longes_kickoff_return'] = (string)$pvalue['longes_kickoff_return'];
                                                $playerStatsArray['category'][$i]['player'][$j]['kickoff_return_touchdows'] = (string)$pvalue['kickoff_return_touchdows'];
                                                $playerStatsArray['category'][$i]['player'][$j]['punts_returned'] = (string)$pvalue['punts_returned'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_returned_on_punts'] = (string)$pvalue['yards_returned_on_punts'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_per_punt_avg'] = (string)$pvalue['yards_per_punt_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['longest_punt_return'] = (string)$pvalue['longest_punt_return'];
                                                $playerStatsArray['category'][$i]['player'][$j]['punt_return_touchdowns'] = (string)$pvalue['punt_return_touchdowns'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fair_catches'] = (string)$pvalue['fair_catches'];
                                                $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                $j++;   
                                               }
                                            }
                                            
                                            if((string)$dvalue['name'] == 'Kicking'){
                                                foreach($dvalue as $pkey=>$pvalue){ 
                                                    $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_made'] = (string)$pvalue['field_goals_made'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_attempts'] = (string)$pvalue['field_goals_attempts'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_made_pct'] = (string)$pvalue['field_goals_made_pct'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['longest_goal_made'] = (string)$pvalue['longest_goal_made'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_from_1_19_yards'] = (string)$pvalue['field_goals_from_1_19_yards'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_from_20_29_yards'] = (string)$pvalue['field_goals_from_20_29_yards'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_from_30_39_yards'] = (string)$pvalue['field_goals_from_30_39_yards'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_from_40_49_yards'] = (string)$pvalue['field_goals_from_40_49_yards'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['field_goals_from_50_yards'] = (string)$pvalue['field_goals_from_50_yards'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['extra_points_made'] = (string)$pvalue['extra_points_made'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['extra_points_attempts'] = (string)$pvalue['extra_points_attempts'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['extra_points_made_pct'] = (string)$pvalue['extra_points_made_pct'];
                                                    $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                    $j++;   
                                                }
                                            }
                                            
                                            if((string)$dvalue['name'] == 'Punting'){
                                            foreach($dvalue as $pkey=>$pvalue){ 
                                                $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                $playerStatsArray['category'][$i]['player'][$j]['punts'] = (string)$pvalue['punts'];
                                                $playerStatsArray['category'][$i]['player'][$j]['gross_punt_yards'] = (string)$pvalue['gross_punt_yards'];
                                                $playerStatsArray['category'][$i]['player'][$j]['longest_punt'] = (string)$pvalue['longest_punt'];
                                                $playerStatsArray['category'][$i]['player'][$j]['gross_punting_avg'] = (string)$pvalue['gross_punting_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['net_punting_avg'] = (string)$pvalue['net_punting_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['blocked_punts'] = (string)$pvalue['blocked_punts'];
                                                $playerStatsArray['category'][$i]['player'][$j]['inside_20_yards_punt'] = (string)$pvalue['inside_20_yards_punt'];
                                                $playerStatsArray['category'][$i]['player'][$j]['touchbacks'] = (string)$pvalue['touchbacks'];
                                                $playerStatsArray['category'][$i]['player'][$j]['fair_catches'] = (string)$pvalue['fair_catches'];
                                                $playerStatsArray['category'][$i]['player'][$j]['punts_returned'] = (string)$pvalue['punts_returned'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_returned_on_punts'] = (string)$pvalue['yards_returned_on_punts'];
                                                $playerStatsArray['category'][$i]['player'][$j]['yards_returned_on_punts_avg'] = (string)$pvalue['yards_returned_on_punts_avg'];
                                                $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                $j++;   
                                               }
                                            }
                                            
                                        $i++;
                                    }
                                    array_push($playervalue, $playerStatsArray);
                          }
                        if(!empty($playervalue)){
                            return $playervalue;
                        }
                    }
                    break;
                    case 'MLB':
                        
                        $url['ari'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/ari_stats';
                        $url['atl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/atl_stats';
                        $url['bal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/bal_stats';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/bos_stats';
                        $url['chc'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/chc_stats';
                        $url['chw'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/chw_stats';
                        $url['cin'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/cin_stats';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/cle_stats';
                        $url['col'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/col_stats';
                        $url['det'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/det_stats';
                        $url['fla'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/fla_stats';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/hou_stats'; 
                        $url['kan'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/kan_stats';
                        //$url['KC']  = '';
                        $url['laa'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/laa_stats';
                        $url['lad'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/lad_stats';
                        //$url['Mia'] = '';
                        $url['mil'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/mil_stats';
                        $url['min'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/min_stats';
                        $url['nym'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/nym_stats';
                        $url['nyy'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/nyy_stats';
                        $url['oak'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/oak_stats';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/phi_stats';
                        $url['pit'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/pit_stats';
                        //$url['SD']  = '';
                        //$url['SF']  = '';
                        $url['sdg'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sdg_stats';
                        $url['sea'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sea_stats';
                        $url['sfo'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sfo_stats';
                        $url['stl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/stl_stats';
                        //$url['TB']  = '';
                        $url['tam'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tam_stats';
                        $url['tex'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tex_stats';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tor_stats';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/was_stats';
        
                         $playerStatsArray = array();
                         $playervalue = array();  
                         foreach ($url as $ukey => $uvalue) {
                                
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());   
                                    $data = $this->xmlLoad($response);
                                    $i = 0;  
                                    $playerStatsArray['team'] = (string)$data['team'];
                                    $playerStatsArray['id'] = (string)$data['id'];
                                    foreach ($data as $dkey => $dvalue) {                                       
                                        $playerStatsArray['category'][$i]['name']= (string)$dvalue['name'];
                                        
                                        $j = 0;
                                        if (isset($dvalue->leaders)) {                                            
                                            foreach ($dvalue as $pvalue) {
                                                if (isset($pvalue->leader)) {
                                                    foreach ($pvalue as $qvalue) {
                                                        if (isset($qvalue['type'])) {
                                                        $playerStatsArray['category'][$i]['leaders'][$j]['type'] = (string)$qvalue['type'];
                                                        }
                                                        
                                                        if (isset($qvalue['name'])) {
                                                        $playerStatsArray['category'][$i]['leaders'][$j]['name'] = (string)$qvalue['name'];
                                                        }
                                                        
                                                        if (isset($qvalue['on_base_percentage'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['on_base_percentage'] = (string)$qvalue['on_base_percentage'];
                                                        }

                                                        if (isset($qvalue['average'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['average'] = (string)$qvalue['average'];
                                                        }
                                                        
                                                        if (isset($qvalue['home_runs'])) {
                                                        $playerStatsArray['category'][$i]['leaders'][$j]['home_runs'] = (string)$qvalue['home_runs'];
                                                        }
                                                        
                                                        if (isset($qvalue['sugging_percentage'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['sugging_percentage'] = (string)$qvalue['sugging_percentage'];
                                                        }

                                                        if (isset($qvalue['games_played'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['games_played'] = (string)$qvalue['games_played'];
                                                        }

                                                        if (isset($qvalue['runs_batted_in'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['runs_batted_in'] = (string)$qvalue['runs_batted_in'];
                                                        }

                                                        if (isset($qvalue['runs'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['runs'] = (string)$qvalue['runs'];
                                                        }

                                                        if (isset($qvalue['game_played'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['game_played'] = (string)$qvalue['game_played'];
                                                        }
                                                        
                                                        if (isset($qvalue['hits'])) {
                                                        $playerStatsArray['category'][$i]['leaders'][$j]['hits'] = (string)$qvalue['hits'];
                                                        }

                                                        if (isset($qvalue['walks'])) {
                                                            $playerStatsArray['category'][$i]['leaders'][$j]['walks'] = (string)$qvalue['walks'];
                                                        }

                                                        if (isset($qvalue['id'])) {
                                                        $playerStatsArray['category'][$i]['leaders'][$j]['id'] = (string)$qvalue['id'];
                                                        }
                                                        $j++;
                                                    }
                                                }
                                                
                                            }
                                        }
                                        if(isset($dvalue->team)){
                                            $j = 0;
                                             foreach ($dvalue->team as $pvalue) {
                                             
                                                 foreach ($pvalue as $qvalue) {
                                                    
                                                 if (isset($qvalue['rank'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['rank'] = (string)$qvalue['rank'];
                                                 }
                                                 
                                                 if (isset($qvalue['name'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['name'] = (string)$qvalue['name'];
                                                 }
                                                 
                                                 if (isset($qvalue['games_played'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['games_played'] = (string)$qvalue['games_played'];
                                                 }
                                                 
                                                 if (isset($qvalue['games_started'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['games_started'] = (string)$qvalue['games_started'];
                                                 }
                                                 
                                                 if (isset($qvalue['wins'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['wins'] = (string)$qvalue['wins'];
                                                 }
                                                 
                                                 if (isset($qvalue['losses'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['losses'] = (string)$qvalue['losses'];
                                                 }
                                                 
                                                 if (isset($qvalue['saves'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['saves'] = (string)$qvalue['saves'];
                                                 }
                                                 
                                                 if (isset($qvalue['quality_starts'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['quality_starts'] = (string)$qvalue['quality_starts'];
                                                 }
                                                 
                                                 if (isset($qvalue['holds'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['holds'] = (string)$qvalue['holds'];
                                                 }
                                                 
                                                 if (isset($qvalue['innings_pitched'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['innings_pitched'] = (string)$qvalue['innings_pitched'];
                                                 }
                                                 
                                                 if (isset($qvalue['earned_runs'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['earned_runs'] = (string)$qvalue['earned_runs'];
                                                 }
                                                 
                                                 if (isset($qvalue['at_bats'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['at_bats'] = (string)$qvalue['at_bats'];
                                                 }
                                                 
                                                 if (isset($qvalue['runs'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['runs'] = (string)$qvalue['runs'];
                                                 }
                                                 
                                                 if (isset($qvalue['hits'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['hits'] = (string)$qvalue['hits'];
                                                 }
                                                 
                                                 if (isset($qvalue['doubles'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['doubles'] = (string)$qvalue['doubles'];
                                                 }
                                                 
                                                 if (isset($qvalue['triples'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['triples'] = (string)$qvalue['triples'];
                                                 }
                                                 
                                                 if (isset($qvalue['home_runs'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['home_runs'] = (string)$qvalue['home_runs'];
                                                 }
                                                 
                                                 if (isset($qvalue['total_bases'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['total_bases'] = (string)$qvalue['total_bases'];
                                                 }
                                                 
                                                 if (isset($qvalue['rans_bated_in'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['rans_bated_in'] = (string)$qvalue['rans_bated_in'];
                                                 }
                                                 
                                                 if (isset($qvalue['runs_batted_in'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['runs_batted_in'] = (string)$qvalue['runs_batted_in'];
                                                 }
                                                 
                                                 if (isset($qvalue['walks'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['walks'] = (string)$qvalue['walks'];
                                                 }
                                                 
                                                 if (isset($qvalue['stolen_bases'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['stolen_bases'] = (string)$qvalue['stolen_bases'];
                                                 }
                                                 
                                                 if (isset($qvalue['strikeouts'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['strikeouts'] = (string)$qvalue['strikeouts'];
                                                 }
                                                 
                                                 if (isset($qvalue['strikeouts_per_9_innings'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['strikeouts_per_9_innings'] = (string)$qvalue['strikeouts_per_9_innings'];
                                                 }
                                                 
                                                 if (isset($qvalue['pitches_per_start'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['pitches_per_start'] = (string)$qvalue['pitches_per_start'];
                                                 }
                                                 
                                                 if (isset($qvalue['walk_hits_per_inning_pitched'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['walk_hits_per_inning_pitched'] = (string)$qvalue['walk_hits_per_inning_pitched'];
                                                 }
                                                 
                                                 if (isset($qvalue['earned_run_average'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['earned_run_average'] = (string)$qvalue['earned_run_average'];
                                                 }
                                                 
                                                 if (isset($qvalue['caught_stealing'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['caught_stealing'] = (string)$qvalue['caught_stealing'];
                                                 }
                                                 
                                                 if (isset($qvalue['batting_avg'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['batting_avg'] = (string)$qvalue['batting_avg'];
                                                 }
                                                 
                                                 if (isset($qvalue['slugging_percentage'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['slugging_percentage'] = (string)$qvalue['slugging_percentage'];
                                                 }
                                                 
                                                 if (isset($qvalue['id'])) {
                                                 $playerStatsArray['category'][$i]['team']['player'][$j]['id'] = (string)$qvalue['id'];
                                                 }
                                                 
                                                 $j++;
                                                }
                                             }
                                        }
                                        
                                        if(isset($dvalue->position)){   
                                            $j = 0;
                                             foreach ($dvalue->position as $value){
                                               $playerStatsArray['category'][$i]['position'][$j]['name'] = (string)$value['name'];
                                               $k = 0;
                                               foreach ($value as $pvalue){
                                                   
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['rank'] = (string)$pvalue['rank'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['name'] = (string)$pvalue['name'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['games_played'] = (string)$pvalue['games_played'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['games_started'] = (string)$pvalue['games_started'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['full_innings'] = (string)$pvalue['full_innings'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['total_chances'] = (string)$pvalue['total_chances'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['putouts'] = (string)$pvalue['putouts'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['assists'] = (string)$pvalue['assists'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['errors'] = (string)$pvalue['errors'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['double_plays'] = (string)$pvalue['double_plays'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['fielding_percentage'] = (string)$pvalue['fielding_percentage'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['range_factor'] = (string)$pvalue['range_factor'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['zone_rating'] = (string)$pvalue['zone_rating'];
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['id'] = (string)$pvalue['id'];
                                                   
                                                   if (isset($pvalue['passed_balls'])) {
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['passed_balls'] = (string)$pvalue['passed_balls'];
                                                   }
                                                   
                                                   if (isset($pvalue['catcher_stolen_bases'])) {
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['catcher_stolen_bases'] = (string)$pvalue['catcher_stolen_bases'];
                                                   }
                                                   
                                                   if (isset($pvalue['catcher_caught'])) {
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['catcher_caught'] = (string)$pvalue['catcher_caught'];
                                                   }
                                                   
                                                   if (isset($pvalue['catcher_caught_stealing_percentage'])) {
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['catcher_caught_stealing_percentage'] = (string)$pvalue['catcher_caught_stealing_percentage'];
                                                   }
                                                   
                                                   if (isset($pvalue['earned_run_average'])) {
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['earned_run_average'] = (string)$pvalue['earned_run_average'];
                                                   }
                                                   
                                                   $playerStatsArray['category'][$i]['position'][$j]['player'][$k]['id'] = (string)$pvalue['id'];
                                                   $k++;
                                               }                                                   
                                               $j++;
                                             }
                                        }
                                        $i++;
                                        
                                    }      
//                         Print"<pre>";print_r($playerStatsArray);print"</pre>";die;
                                     array_push($playervalue, $playerStatsArray);
                         }
                         if(!empty($playervalue)){
                              return $playervalue;
                         }
                        break;
                    case 'NBA':
                      

                        $url['atl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/atl_stats';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/bos_stats';
//                        $url['Bkn'] = '';
                        $url['cha'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cha_stats';
                        $url['chi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/chi_stats';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cle_stats';
                        $url['dal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/dal_stats';
                        $url['den'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/den_stats';
                        $url['det'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/det_stats';
                        $url['gs'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/gs_stats';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/hou_stats';
                        $url['ind'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ind_stats';
                        $url['lac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lac_stats';
                        $url['lal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lal_stats';
                        $url['mem'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mem_stats';
                        $url['mia'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mia_stats';
                        $url['mil'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mil_stats';
                        $url['min'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/min_stats';
                        $url['nj'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/nj_stats';
                        $url['no'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/no_stats';
                        $url['ny'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ny_stats';
                        $url['okc'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/okc_stats';
                        $url['orl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/orl_stats';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phi_stats';
                        $url['phx'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phx_stats';
                        $url['por'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/por_stats';
                        $url['sac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sac_stats';
                        $url['sa'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sa_stats';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/tor_stats';
                        $url['uta'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/utah_stats';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/wsh_stats';
                        
                        
                         
                         $playerStatsArray = array();
                         $playervalue = array();                      
                         foreach ($url as $ukey => $uvalue) {
                                
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody()); 
                                    $data = $this->xmlLoad($response);
                                    $i = 0;         
                                    $playerStatsArray['team'] = (string)$data['team'];
                                    $playerStatsArray['id'] = (string)$data['id'];
                                   // echo "<pre>"; print_r($playerStatsArray); echo "</pre>"; die;
                                    foreach ($data as $dkey => $dvalue) {  
                                       
                                        $playerStatsArray['category'][$i]['name']= (string)$dvalue['name'];                                       
                                        $j = 0;                                               
                                            foreach ($dvalue as $pvalue) {                                                                                              
                                                    
                                                        if (isset($pvalue['rank'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                        }
                                                        
                                                        if (isset($pvalue['name'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                        }
                                                        
                                                        if (isset($pvalue['games_played'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['games_played'] = (string)$pvalue['games_played'];
                                                        }
                                                        
                                                        if (isset($pvalue['games_started'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['games_started'] = (string)$pvalue['games_started'];
                                                        }
                                                        
                                                        if (isset($pvalue['minutes'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['minutes'] = (string)$pvalue['minutes'];
                                                        }
                                                        
                                                        if (isset($pvalue['points_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['points_per_game'] =(string) $pvalue['points_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['offensive_rebounds_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['offensive_rebounds_per_game'] = (string)$pvalue['offensive_rebounds_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['defensive_rebounds_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['defensive_rebounds_per_game'] = (string)$pvalue['defensive_rebounds_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['rebounds_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['rebounds_per_game'] = (string)$pvalue['rebounds_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['assists_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['assists_per_game'] = (string)$pvalue['assists_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['steals_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['steals_per_game'] = (string)$pvalue['steals_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['blocks_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['blocks_per_game'] = (string)$pvalue['blocks_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['turnovers_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['turnovers_per_game'] = (string)$pvalue['turnovers_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['fouls_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['fouls_per_game'] =(string) $pvalue['fouls_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['efficiency_rating'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['efficiency_rating'] = (string)$pvalue['efficiency_rating'];
                                                        }
                                                        
                                                        if (isset($pvalue['fg_made_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['fg_made_per_game'] = (string)$pvalue['fg_made_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['fg_attempts_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['fg_attempts_per_game'] = (string)$pvalue['fg_attempts_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['fg_pct'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['fg_pct'] = (string)$pvalue['fg_pct'];
                                                        }
                                                        
                                                        if (isset($pvalue['three_point_made_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['three_point_made_per_game'] = (string)$pvalue['three_point_made_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['three_point_attempts_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['three_point_attempts_per_game'] = (string)$pvalue['three_point_attempts_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['three_point_pct'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['three_point_pct'] =(string) $pvalue['three_point_pct'];
                                                        }
                                                        
                                                        if (isset($pvalue['free_throws_made_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['free_throws_made_per_game'] =(string) $pvalue['free_throws_made_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['free_throws_attempts_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['free_throws_attempts_per_game'] =(string) $pvalue['free_throws_attempts_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['free_throws_pct'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['free_throws_pct'] = (string)$pvalue['free_throws_pct'];
                                                        }
                                                        
                                                        if (isset($pvalue['two_point_made_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['two_point_made_per_game'] = (string)$pvalue['two_point_made_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['two_point_attemps_per_game'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['two_point_attemps_per_game'] = (string)$pvalue['two_point_attemps_per_game'];
                                                        }
                                                        
                                                        if (isset($pvalue['two_point_pct'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['two_point_pct'] =(string) $pvalue['two_point_pct'];
                                                        }
                                                        
                                                        if (isset($pvalue['points_per_shot'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['points_per_shot'] =(string) $pvalue['points_per_shot'];
                                                        }
                                                        
                                                        if (isset($pvalue['field_goal_pct_avg'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['field_goal_pct_avg'] = (string)$pvalue['field_goal_pct_avg'];
                                                        }
                                                        
                                                        if (isset($pvalue['id'])) {
                                                        $playerStatsArray['category'][$i]['player'][$j]['id'] =(string) $pvalue['id'];
                                                        }
                                                        
                                                        
                                                        $j++;
                                            }
                                       
                                        $i++;
                                        
                                    }
                                      
                                      array_push($playervalue, $playerStatsArray);
                         }       
                        if(!empty($playervalue)){
                         return (array)$playervalue;
                        }
                        break;
                    /**
                    * Developer    : Vivek Chaudhari
                    * Description  : get NHL player stats
                    * Date         : 17/10/2014
                    * @return      : <array> player stats details
                    */
                     case 'NHL':
                                $url['ana'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ana_stats';
                                $url['atl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/atl_stats';
                                $url['bos'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/bos_stats';
                                $url['buf'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/buf_stats';
                                $url['car'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/car_stats';
                                $url['cbs'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cbj_stats';
                                $url['cgy'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cgy_stats';
                                $url['chi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/chi_stats';
                                $url['col'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/col_stats';
                                $url['dal'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/dal_stats';
                                $url['det'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/det_stats';
                                $url['edm'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/edm_stats';
                                $url['fla'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/fla_stats';
                                $url['la']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/la_stats';
                                $url['min'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/min_stats';
                                $url['mtl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/mtl_stats';
                                $url['nj']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nj_stats';
                                $url['nsh'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nsh_stats';
                                $url['nyi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyi_stats';
                                $url['nyr'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyr_stats';
                                $url['ott'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ott_stats';
                                $url['phi'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phi_stats';
                                $url['phx'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phx_stats';
                                $url['pit'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/pit_stats';
                                $url['sj']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/sj_stats';
                                $url['stl'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/stl_stats';
                                $url['tb']  =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tb_stats';
                                $url['tor'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tor_stats';
                                $url['van'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/van_stats';
                                $url['wsh'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/wsh_stats'; 
//                                $url['fla'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/fla_stats';
                                $playerStatsArray = array();
                                $playervalue = array();                      
                         foreach ($url as $ukey => $uvalue) {
                                // under development
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request(); 
                                    $data = $this->xmlLoad($response);
                                    $playerStatsArray['team'] = (string)$data['team'];
                                    $playerStatsArray['id'] = (string)$data['id'];
                                    $i = 0;
                                    foreach($data as $dkey=>$dvalue){
                                        $playerStatsArray['category'][$i]['name'] = $dkey;
                                        $j= 0;
                                        if(isset($dvalue->player)){
                                            foreach($dvalue->player as $pkey=>$pvalue){
                                                if(isset($pvalue['rank'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['rank'] = (string)$pvalue['rank'];
                                                }
                                                if(isset($pvalue['name'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['name'] = (string)$pvalue['name'];
                                                }
                                                if(isset($pvalue['pos'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['pos'] = (string)$pvalue['pos'];
                                                }
                                                if(isset($pvalue['games_played'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['games_played'] = (string)$pvalue['games_played'];
                                                }
                                                if(isset($pvalue['goals'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['goals'] = (string)$pvalue['goals'];
                                                }
                                                if(isset($pvalue['assists'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['assists'] = (string)$pvalue['assists'];
                                                }
                                                if(isset($pvalue['points'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['points'] = (string)$pvalue['points'];
                                                }
                                                if(isset($pvalue['plus_minus'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['plus_minus'] = (string)$pvalue['plus_minus'];
                                                }
                                                if(isset($pvalue['penalty_minutes'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['penalty_minutes'] = (string)$pvalue['penalty_minutes'];
                                                }
                                                if(isset($pvalue['shifts'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['shifts'] = (string)$pvalue['shifts'];
                                                }
                                                if(isset($pvalue['game_winning_goals'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['game_winning_goals'] = (string)$pvalue['game_winning_goals'];
                                                }
                                                if(isset($pvalue['faceoffs_won'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['faceoffs_won'] = (string)$pvalue['faceoffs_won'];
                                                }
                                                if(isset($pvalue['faceoffs_lost'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['faceoffs_lost'] = (string)$pvalue['faceoffs_lost'];
                                                }
                                                if(isset($pvalue['faceoffs_pct'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['faceoffs_pct'] = (string)$pvalue['faceoffs_pct'];
                                                }
                                                if(isset($pvalue['production_time'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['production_time'] = (string)$pvalue['production_time'];
                                                }
                                                if(isset($pvalue['shootout_attempts'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['shootout_attempts'] = (string)$pvalue['shootout_attempts'];
                                                }
                                                if(isset($pvalue['shootout_goals'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['shootout_goals'] = (string)$pvalue['shootout_goals'];
                                                }
                                                if(isset($pvalue['shootout_pct'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['shootout_pct'] = (string)$pvalue['shootout_pct'];
                                                }
                                                if(isset($pvalue['id'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['id'] = (string)$pvalue['id'];
                                                }
                                                
                                                if(isset($pvalue['wins'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['wins'] = (string)$pvalue['wins'];
                                                }
                                                if(isset($pvalue['losses'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['losses'] = (string)$pvalue['losses'];
                                                }
                                                if(isset($pvalue['ot_losses'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['ot_losses'] = (string)$pvalue['ot_losses'];
                                                }
                                                if(isset($pvalue['goals_against_diff'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['goals_against_diff'] = (string)$pvalue['goals_against_diff'];
                                                }
                                                if(isset($pvalue['time_on_ice'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['time_on_ice'] = (string)$pvalue['time_on_ice'];
                                                }
                                                if(isset($pvalue['saves'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['saves'] = (string)$pvalue['saves'];
                                                }
                                                if(isset($pvalue['saves_pct'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['saves_pct'] = (string)$pvalue['saves_pct'];
                                                }
                                                if(isset($pvalue['shutouts'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['shutouts'] = (string)$pvalue['shutouts'];
                                                }
                                                if(isset($pvalue['total_goals_against'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['total_goals_against'] = (string)$pvalue['total_goals_against'];
                                                }
                                                if(isset($pvalue['total_shots_against'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['total_shots_against'] = (string)$pvalue['total_shots_against'];
                                                }
                                                if(isset($pvalue['penalty_minutes'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['penalty_minutes'] = (string)$pvalue['penalty_minutes'];
                                                }
                                                if(isset($pvalue['empty_net_goals'])){
                                                    $playerStatsArray['category'][$i]['player'][$j]['empty_net_goals'] = (string)$pvalue['empty_net_goals'];
                                                }
                                                $j++;
                                            } 
                                        }
                                         $i++;
                                    }  
                                 array_push($playervalue, $playerStatsArray);
                            }
                            if(!empty($playervalue)){
                                return $playervalue;
                            }
                         break ;
                    default:
                        break;
                }
            }
        }      

        /**
         * Developer : Manoj kosare
         * Description : get player details by game
         * @return <array>
         */
        public function getGamePlayers(){
            
            if(func_num_args() > 0){
                $gameType = func_get_arg(0);
                $objAbbreviation = Engine_Utilities_Abbreviations::getInstance();
                switch ($gameType) {
                    /**
                    * Developer    : Vivek Chaudhari
                    * Description  : get NFL game Players list and details
                    * Date         : 28/08/2014
                    * @return      : <array> player list details
                    */
                    case 'NFL':
                        $abbreviation = (array)json_decode($objAbbreviation->getNFLAbbreviations());// get team Abbreviations
                        $url['Ari'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ari_rosters';
                        $url['Atl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/atl_rosters';
                        $url['Bal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/bal_rosters';
                        $url['Buf'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/buf_rosters';
                        $url['Car'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/car_rosters';
                        $url['Chi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/chi_rosters';
                        $url['Cin'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cin_rosters';
                        $url['Cle'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/cle_rosters';
                        $url['Dal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/dal_rosters';
                        $url['Den'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/den_rosters';
                        $url['Det'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/det_rosters';
                        $url['GB']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/gb_rosters';
                        $url['Hou'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/hou_rosters';
                        $url['Ind'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ind_rosters';
                        $url['Jac'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/jac_rosters';
                        $url['KC']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/kc_rosters';
                        $url['Mia'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/mia_rosters';
                        $url['Min'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/min_rosters';
                        $url['NYG'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyg_rosters';
                        $url['NYJ'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/nyj_rosters';
                        $url['NE']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ne_rosters';
                                
                        $url['NO']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/no_rosters';
                        $url['Oak'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/oak_rosters';
                        $url['Phi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/phi_rosters';
                        $url['Pit'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/pit_rosters';
                        $url['SD']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sd_rosters';
                        $url['SF']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sf_rosters';
                        $url['Sea'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/sea_rosters';
                        $url['StL'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/stl_rosters';
                        $url['TB']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/tb_rosters';
                        $url['Ten'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/ten_rosters';
                        $url['Wsh'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/wsh_rosters';
                          
                        $playerListArray = array();
                         
                        foreach ($url as $ukey => $uvalue) {

                            $client = new Zend_Http_Client($uvalue);
                            $response = $client->request();
                            $data = $this->xmlLoad($response); 
                            
                                if(isset($data)){
                                    $name = ((string) $data['name']);
                                    $nameArray = explode(" ", $name);
                                    $tname = end($nameArray);
                                    $playervalue['name'] = $tname;
                                    $playervalue['position'] = "DST";
                                    $playervalue['pos_code'] = "DST";
                                    $playervalue['id'] = (string) $data['id'];
                                    $playervalue['team_name'] = ((string) $data['name']);
                                    $team_code = array_search((string) $data['name'], $abbreviation);
                                    $playervalue['team_code'] = $team_code;
                                    array_push($playerListArray, $playervalue); 
                                } 
                                //echo "<pre>"; print_r($data->position->player); echo "</pre>"; die;
                         if(isset($data->position->player)){
                                foreach($data->position->player as $key=>$pvalue){
                                    $playervalue['number'] = (string) $pvalue['number'];
                                    $playervalue['name'] = ((string) $pvalue['name']);
                                    $playervalue['position'] = ((string) $pvalue['position']);
                                    $playervalue['pos_code'] = (string) $pvalue['position'];
                                    $playervalue['college'] = ((string) $pvalue['college']);
                                    $playervalue['age'] = ((string) $pvalue['age']);
                                    $playervalue['height'] = (string) $pvalue['height'];
                                    $playervalue['weight'] = (string) $pvalue['weight'];
                                    $playervalue['experience_years'] = (string) $pvalue['experience_years'];
                                    $playervalue['id'] = (string) $pvalue['id'];
                                    $playervalue['team_name'] = ((string) $data['name']);
                                    $team_code = array_search((string) $data['name'], $abbreviation);
                                    $playervalue['team_code'] = $team_code;
                                    array_push($playerListArray, $playervalue); 
                                } 
                        }
                        
                        if(isset($data->position[2])){
                                foreach($data->position[2] as $kickKey=>$kickValue){ 
                                    if($kickValue['position'] == "PK"){ //echo "<pre>"; print_r($kickValue); echo "</pre>"; //die;
                                        $playervalue['number'] = (string) $kickValue['number'];
                                        $playervalue['name'] = ((string) $kickValue['name']);
                                        $playervalue['position'] = "K"; //(string) $kickValue['position'];
                                        $playervalue['pos_code'] = "K"; 
                                        $playervalue['college'] = ((string) $kickValue['college']);
                                        $playervalue['age'] = ((string) $kickValue['age']);
                                        $playervalue['height'] = (string) $kickValue['height'];
                                        $playervalue['weight'] = (string) $kickValue['weight'];
                                        $playervalue['experience_years'] = (string) $kickValue['experience_years'];
                                        $playervalue['id'] = (string) $kickValue['id'];
                                        $playervalue['team_name'] = ((string) $data['name']);
                                        $team_code = array_search((string) $data['name'], $abbreviation);
                                        $playervalue['team_code'] = $team_code;
                                        array_push($playerListArray, $playervalue); 
                                    }
                                } //echo "<pre>"; print_r($playerListArray); echo "</pre>"; die;
                        }
                            } //die('test');
                        
                            if(!empty($playerListArray)){
                                $playerListArray = array_values($playerListArray);
                                return $playerListArray;
                            }
//                        ----------------end NFL--------------------
                        break;
                    case 'MLB':
                        
                        $abbreviation = (array)json_decode($objAbbreviation->getMLBAbbreviations());// get team Abbreviations
                        $url['ari'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/ari_rosters';
                        $url['atl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/atl_rosters';
                        $url['bal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/bal_rosters';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/bos_rosters';
                        $url['chc'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/chc_rosters';
                        
                        $url['chw'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/chw_rosters';
                        $url['cin'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/cin_rosters';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/cle_rosters';
                        $url['col'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/col_rosters';
                        $url['det'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/det_rosters';
                        
                        $url['fla'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/fla_rosters';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/hou_rosters'; 
                        $url['kan'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/kan_rosters';
                        //$url['KC']  = '';
                        $url['laa'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/laa_rosters';
                        $url['lad'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/lad_rosters';
                        //$url['Mia'] = '';
                        
                        $url['mil'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/mil_rosters';
                        $url['min'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/min_rosters';
                        $url['nym'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/nym_rosters';
                        $url['nyy'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/nyy_rosters';
                        $url['oak'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/oak_rosters';
                        
                        $url['phi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/phi_rosters';
                        $url['pit'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/pit_rosters';
                        //$url['SD']  = '';
                        //$url['SF']  = '';
                        $url['sdg'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sdg_rosters';
                        $url['sea'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sea_rosters';
                        $url['sfo'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/sfo_rosters';
                        
                        $url['stl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/stl_rosters';
                        //$url['TB']  = '';
                        $url['tam'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tam_rosters';
                        $url['tex'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tex_rosters';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/tor_rosters';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/was_rosters';
        
                         $playerListArray = array();
                         
                         foreach ($url as $ukey => $uvalue) {
                                 //echo $uvalue.'<br/>';
                                    $client = new Zend_Http_Client($uvalue);      
                                    $response = $client->request();
//                                    $data = simplexml_load_string($response->getBody());
                                      $data = $this->xmlLoad($response);
//                                    print"<pre>";print_r($data);print"</pre>";
                                    foreach ($data as $dkey => $dvalue) {
//                                        echo "<br/><br/> dvalue ---------------------------------------<br/><br/>";
//                                        print"<pre>";print_r($dvalue);print"</pre>";
                                        foreach ($dvalue as $pkey => $pvalue) {
//                                            echo "<br/><br/> pvalue ---------------------------------------<br/><br/>";
//                                            print"<pre>";print_r($pvalue);print"</pre>";die;
                                            $playervalue['number']      = (string) $pvalue['number'];
                                            $playervalue['name']        = ((string) $pvalue['name']);
                                            $playervalue['position']    = ((string) $pvalue['position']);
                                            $playervalue['bats']        = ((string) $pvalue['bats']);
                                            $playervalue['throws']      = ((string) $pvalue['throws']);
                                            $playervalue['age']         = ((string) $pvalue['age']);
                                            $playervalue['height']      = ((string) $pvalue['height']);
                                            $playervalue['weight']      = ((string) $pvalue['weight']);
                                            $playervalue['id']          = (string) $pvalue['id'];
                                            $playervalue['team_name']   = ((string) $data['name']);
                                            $playervalue['position_name'] = ((string) $dvalue['name']);
                                            //$playervalue['pos_code']    = (string) $pvalue['position'];
                                            // get first character of words in given string to create possition code
                                               
                                            $words = explode(" ", (string)$dvalue['name']);
                                            $acronym = "";
                                            foreach ($words as $w) {
                                                $acronym .= $w[0];
                                            }                             
                                            if($acronym == 'O'){
                                                $playervalue['pos_code']        = 'OF';
                                            }else if((string) $pvalue['position'] == '1B'){
                                                $playervalue['pos_code']        = '1B';
                                            }else if((string) $pvalue['position'] == '2B'){
                                                $playervalue['pos_code']        = '2B';
                                            }else if((string) $pvalue['position'] == '3B'){
                                                $playervalue['pos_code']        = '3B';
                                            }else if((string) $pvalue['position'] == 'SS'){
                                                $playervalue['pos_code']        = 'SS';
                                            }else if(strpos((string) $pvalue['position'], 'P')){
                                                    $playervalue['pos_code']  = 'P';
                                            }else{
                                                $playervalue['pos_code']        = $acronym;
                                            }
                                            // create team name code
                                            $team_code = array_search((string)$data['name'], $abbreviation);
                                            $playervalue['team_code'] = $team_code;
                                             
                                            array_push($playerListArray, $playervalue);
                                        }
                                    }                     
                         }
                          
                         if(!empty($playerListArray)){
                             $playerListArray = array_values($playerListArray);
//                             print"<pre>";print_r($playerListArray);print"</pre>";die;
                             return $playerListArray;
                         }
                        break;
                    case 'NBA':
                        $abbreviation = (array)json_decode($objAbbreviation->getNBAAbbreviations());// get team Abbreviations
                        $url['atl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/atl_rosters';
                        $url['bos'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/bos_rosters';
                        $url['cha'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cha_rosters';
                        $url['chi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/chi_rosters';
                        $url['cle'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/cle_rosters';
                        $url['dal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/dal_rosters';
                        $url['den'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/den_rosters';
                        $url['det'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/det_rosters';
                        $url['gs'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/gs_rosters';
                        $url['hou'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/hou_rosters';
                        $url['ind'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ind_rosters';
                        $url['lac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lac_rosters';
                        $url['lal'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/lal_rosters';
                        $url['mem'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mem_rosters';
                        $url['mia'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mia_rosters';
                        $url['mil'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/mil_rosters';
                        $url['min'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/min_rosters';
                        $url['nj'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/nj_rosters';
                        $url['no'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/no_rosters';
                        $url['ny'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/ny_rosters';
                        $url['okc'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/okc_rosters';
                        $url['orl'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/orl_rosters';
                        $url['phi'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phi_rosters';
                        $url['phx'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/phx_rosters';
                        $url['por'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/por_rosters';
                        $url['sac'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sac_rosters';
                        $url['sa'] =  'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/sa_rosters';
                        $url['tor'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/tor_rosters';
                        $url['uta'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/utah_rosters';
                        $url['wsh'] = 'http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/wsh_rosters';
                        
                        $playerListArray = array();
                         
                        foreach ($url as $ukey => $uvalue) {

                            $client = new Zend_Http_Client($uvalue);
                            $response = $client->request();
//                            $data = simplexml_load_string($response->getBody());
                            $data = $this->xmlLoad($response);
//                                print"<pre>";print_r($data);print"</pre>";die;
                            foreach ($data as $dkey => $pvalue) {
                                $playervalue['number'] = (string) $pvalue['number'];
                                $playervalue['name'] = ((string) $pvalue['name']);
                                $playervalue['position'] = ((string) $pvalue['position']);
                                $playervalue['college'] = ((string) $pvalue['college']);
                                $playervalue['age'] = ((string) $pvalue['age']);
                                $playervalue['height'] = (string) $pvalue['heigth'];
                                $playervalue['weight'] = (string) $pvalue['weigth'];
                                $playervalue['id'] = (string) $pvalue['id'];
                                $playervalue['team_name'] = ((string) $data['name']);

                                $words = explode(" ", (string) $data['name']);

                                $acronym = "";
                                foreach ($words as $w) {
                                    $acronym .= $w[0];
                                }

                                $playervalue['pos_code'] = (string) $pvalue['position'];

                                // create team name code
                                $team_code = array_search((string) $data['name'], $abbreviation);
                                $playervalue['team_code'] = $team_code;

                                array_push($playerListArray, $playervalue);
                            }  //print"<pre>";print_r($playerListArray);print"</pre>";die;
                    }

                     if(!empty($playerListArray)){
                         $playerListArray = array_values($playerListArray);
                         return $playerListArray;
                     } 
                        break;
                    /**
                    * Developer    : Vivek Chaudhari
                    * Description  : get NHL game Players list and details
                    * Date         : 17/10/2014
                    * @return      : <array> player list details
                    */    
                    case 'NHL':
                        $abbreviation = (array)json_decode($objAbbreviation->getNHLAbbreviations());// get team Abbreviations
                        $url['Ana'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ana_rosters';
                        $url['Win'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/atl_rosters';
                        $url['Bos'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/bos_rosters';
                        $url['Buf'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/buf_rosters';
                        $url['Car'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/car_rosters';
                        $url['Cbs'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cbj_rosters';
                        $url['Cgy'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/cgy_rosters';
                        $url['Chi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/chi_rosters';
                        $url['Col'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/col_rosters';
                        $url['Dal'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/dal_rosters';
                        $url['Det'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/det_rosters';
                        $url['Edm'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/edm_rosters';
                        $url['LA']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/la_rosters';
                        $url['Min'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/min_rosters';
                        $url['Mtl'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/mtl_rosters';
                        $url['NJ']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nj_rosters';
                        $url['Nsh'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nsh_rosters';
                        $url['NYI'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyi_rosters';
                        $url['NYR'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nyr_rosters';
                        $url['Ott'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/ott_rosters';
                        $url['Phi'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phi_rosters';
                        $url['Arc'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/phx_rosters';
                        $url['Pit'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/pit_rosters';
                        $url['SJ']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/sj_rosters';
                        $url['StL'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/stl_rosters';
                        $url['TB']  = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tb_rosters';
                        $url['Tor'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/tor_rosters';
                        $url['Van'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/van_rosters';
                        $url['Fla'] = 'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/fla_rosters';
                        $url['Wsh'] =  'http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/wsh_rosters'; 
                        $playerListArray = array();
                         
                        foreach ($url as $ukey => $uvalue) {

                            $client = new Zend_Http_Client($uvalue);
                         
                            $response = $client->request();
                            $data = $this->xmlLoad($response);
//                              echo "<pre>"; print_r($data); echo "</pre>";die; 
                              foreach ($data as $dkey => $dvalue) {
                                  
                                  foreach($dvalue as $pkey=>$pvalue){
                                      
                                    $playervalue['id'] = (string) $pvalue['id'];
                                    $playervalue['number'] = (string) $pvalue['number'];
                                    $playervalue['name'] = ((string) $pvalue['name']);
                                    $playervalue['birth_place'] = ((string) $pvalue['birth_place']);
                                    $playervalue['age'] = ((string) $pvalue['age']);
                                    $playervalue['height'] = (string) $pvalue['height'];
                                    $playervalue['weight'] = (string) $pvalue['weight'];
                                    $playervalue['team_name'] = ((string) $data['name']);
                                   //create position code and position 
                                    $words = explode(" ", (string) $dvalue['name']);
                                    $acronym = "";
                                    foreach ($words as $w) {
                                        $acronym .= $w[0];
                                        $pos = $w[0];
                                    }
                                    $playervalue['position'] = $acronym;
                                    $playervalue['pos_code'] = $pos; 
                                // create team name code
                                    $team_code = array_search((string) $data['name'], $abbreviation);
                                    $playervalue['team_code'] = $team_code;

                                    array_push($playerListArray, $playervalue);
                               }
                            }  
                        } 
                    if(!empty($playerListArray)){
                         $playerListArray = array_values($playerListArray);
                         return $playerListArray;
                     } 
                        break;
                }
            }
        }
        
        public function xmlLoad($response) {
            try {
                $data = simplexml_load_string($response->getBody());
                return $data;
            } catch (Exception $e) {
                throw new Exception;die;
            }
        }
        
        /**
         * Desc : Get Match Player stats by given date
         */
        public function getMatchStatByDate(){
//            die('tesssssssssssst');
            if(func_num_args() > 0){
                
                $gameType  = func_get_arg(0);
                $matchDate = func_get_arg(1);
                                
                switch ($gameType) {
                    case 'NFL': 
                        $NFL = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/football/?date=".$matchDate;                        
//                  
                        $client = new Zend_Http_Client($NFL);
                        $response = $client->request();
                        $data = $this->xmlLoad($response);
                      
                        $matchesArray = array();
                        
                        $matchesPassingHomeArray = array();
                        $matchesPassingAwayArray = array();
                        
                        $matchesRushingHomeArray = array();
                        $matchesRushingAwayArray = array();                      
                        
                        $matchesReceivingHomeArray = array();
                        $matchesReceivingAwayArray = array();                        
                        
                        $matchesFumblesHomeArray = array();
                        $matchesFumblesAwayArray = array();
                        
                        $matchesInterceptionsHomeArray = array();
                        $matchesInterceptionsAwayArray = array();
                        
                        $matchesDefensiveHomeArray = array();
                        $matchesDefensiveAwayArray = array();
                        
                        $matchesKickreturnsHomeArray = array();
                        $matchesKickreturnsAwayArray = array();
                        
                        $matchesPutreturnsHomeArray = array();
                        $matchesPutreturnsAwayArray = array();
                        
                        $matchesKickingHomeArray = array();
                        $matchesKickingAwayArray = array();
                        
                        $matchesPuntingHomeArray = array();
                        $matchesPuntingAwayArray = array();
                        
                        $matchesKickingHomeArray = array();
                        $matchesKickingAwayArray = array();
                        
                        $matchesStartingHomePitchersArray = array();
                        $matchesStartingAwayPitchersArray = array();
                        
                        $teamStatsHomeArray = array();
                        $teamStatsAwayArray = array();
//                         echo "<pre>"; print_r($data); echo "</pre>"; die; 
                        $i = 0;$j = 0;$k = 0;$l = 0;$m = 0;$n = 0;
                        $o = 0;$p = 0;$q = 0;$r = 0;$s = 0;$t = 0;
                        $u = 0;$v = 0;$w = 0;$x = 0;$y = 0;$z = 0;
                        $z1 = 0; $tH = 0; $tA = 0;
                        if(isset($data->category->match)){
                            
                                foreach($data->category->match as $matches){
                                             
                                 //match stats   
                                       if(isset($matches->team_stats->hometeam)){
                                           foreach($matches->team_stats->hometeam as $homeStats){
                                             $teamStatsHomeArray[$tH]['team_id']  = (string)$matches->hometeam['id'];
                                             $teamStatsHomeArray[$tH]['name']  = (string)$matches->hometeam['name'];
                                             $teamStatsHomeArray[$tH]['sacks'] =  (string)$homeStats->sacks['total'];
                                             $teamStatsHomeArray[$tH]['interception_TD'] =  (string)$homeStats->int_touchdowns['total'];
                                             $teamStatsHomeArray[$tH]['interceptions'] =  (string)$homeStats->interceptions['total'];
                                             $teamStatsHomeArray[$tH]['fumbles_recovered'] =  (string)$homeStats->fumbles_recovered['total'];
                                             $teamStatsHomeArray[$tH]['safeties'] =  (string)$homeStats->safeties['total'];
                                             $teamStatsHomeArray[$tH]['points_allowed'] =  (string)$homeStats->points_against['total'];
                                             $teamStatsHomeArray[$tH]['id']  = (string)$matches->hometeam['id'];
                                             $teamStatsHomeArray[$tH]['type'] = "team_stats";
                                             $tH++;
                                           }
                                       }  
                                       if(isset($matches->team_stats->awayteam)){
                                           foreach($matches->team_stats->awayteam as $homeStats){
                                             $teamStatsAwayArray[$tA]['team_id']  = (string)$matches->awayteam['id'];
                                             $teamStatsAwayArray[$tA]['name']  = (string)$matches->awayteam['name'];
                                             $teamStatsAwayArray[$tA]['sacks'] =  (string)$homeStats->sacks['total'];
                                             $teamStatsAwayArray[$tA]['interception_TD'] =  (string)$homeStats->int_touchdowns['total'];
                                             $teamStatsAwayArray[$tA]['interceptions'] =  (string)$homeStats->interceptions['total'];
                                             $teamStatsAwayArray[$tA]['fumbles_recovered'] =  (string)$homeStats->fumbles_recovered['total'];
                                             $teamStatsAwayArray[$tA]['safeties'] =  (string)$homeStats->safeties['total'];
                                             $teamStatsAwayArray[$tA]['points_allowed'] =  (string)$homeStats->points_against['total'];
                                             $teamStatsAwayArray[$tA]['id']  = (string)$matches->awayteam['id'];
                                             $teamStatsAwayArray[$tA]['type'] = "team_stats";
                                             $tA++;
                                           }
                                       }
//                                     echo "<pre>"; print_r($teamStatsAwayArray); echo "</pre>"; die;           
                                 //passing
                                    if(isset($matches->passing->hometeam->player)){
                                        
                                        foreach($matches->passing->hometeam->player as $homePlayers){

                                            $matchesPassingHomeArray[$i]['name']    = (string)$homePlayers['name'];
                                            $matchesPassingHomeArray[$i]['comp_att']     = (string)$homePlayers['comp_att'];
                                            $matchesPassingHomeArray[$i]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPassingHomeArray[$i]['average']    = (string)$homePlayers['average'];
                                            $matchesPassingHomeArray[$i]['passing_touch_downs']    = (string)$homePlayers['passing_touch_downs'];
                                            $matchesPassingHomeArray[$i]['interceptions'] = (string)$homePlayers['interceptions'];
                                            $matchesPassingHomeArray[$i]['sacks'] = (string)$homePlayers['sacks'];
                                            $matchesPassingHomeArray[$i]['rating'] = (string)$homePlayers['rating'];
                                            $matchesPassingHomeArray[$i]['two_pt'] = (string)$homePlayers['two_pt'];
                                            $matchesPassingHomeArray[$i]['id'] = (string)$homePlayers['id'];
                                            $matchesPassingHomeArray[$i]['type'] = 'Passing';
                                            $i++;

                                        }
                                    }
                                    
                                    if(isset($matches->passing->awayteam->player)){
                                        
                                        foreach($matches->passing->awayteam->player as $homePlayers){
                                            $matchesPassingAwayArray[$j]['name']    = (string)$homePlayers['name'];
                                            $matchesPassingAwayArray[$j]['comp_att']     = (string)$homePlayers['comp_att'];
                                            $matchesPassingAwayArray[$j]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPassingAwayArray[$j]['average']    = (string)$homePlayers['average'];
                                            $matchesPassingAwayArray[$j]['passing_touch_downs']    = (string)$homePlayers['passing_touch_downs'];
                                            $matchesPassingAwayArray[$j]['interceptions'] = (string)$homePlayers['interceptions'];
                                            $matchesPassingAwayArray[$j]['sacks'] = (string)$homePlayers['sacks'];
                                            $matchesPassingAwayArray[$j]['rating'] = (string)$homePlayers['rating'];
                                            $matchesPassingAwayArray[$j]['two_pt'] = (string)$homePlayers['two_pt'];
                                            $matchesPassingAwayArray[$j]['id'] = (string)$homePlayers['id'];  
                                            $matchesPassingAwayArray[$j]['type'] = 'Passing';
                                            $j++;

                                        }
                                    }
                                    ###########################################
                                    //rushing
                                    if(isset($matches->rushing->hometeam->player)){
                                        
                                        foreach($matches->rushing->hometeam->player as $homePlayers){
                                            $matchesRushingHomeArray[$k]['name']    = (string)$homePlayers['name'];
                                            $matchesRushingHomeArray[$k]['total_rushes']     = (string)$homePlayers['total_rushes'];
                                            $matchesRushingHomeArray[$k]['yards'] = (string)$homePlayers['yards'];
                                            $matchesRushingHomeArray[$k]['average']    = (string)$homePlayers['average'];
                                            $matchesRushingHomeArray[$k]['rushing_touch_downs']    = (string)$homePlayers['rushing_touch_downs'];
                                            $matchesRushingHomeArray[$k]['longest_rush'] = (string)$homePlayers['longest_rush'];
                                            $matchesRushingHomeArray[$k]['id'] = (string)$homePlayers['id'];  
                                            $matchesRushingHomeArray[$k]['type'] = 'Rushing';
                                            $k++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->rushing->awayteam->player)){
                                        
                                        foreach($matches->rushing->awayteam->player as $homePlayers){
                                            $matchesRushingAwayArray[$l]['name']    = (string)$homePlayers['name'];
                                            $matchesRushingAwayArray[$l]['total_rushes']     = (string)$homePlayers['total_rushes'];
                                            $matchesRushingAwayArray[$l]['yards'] = (string)$homePlayers['yards'];
                                            $matchesRushingAwayArray[$l]['average']    = (string)$homePlayers['average'];
                                            $matchesRushingAwayArray[$l]['rushing_touch_downs']    = (string)$homePlayers['rushing_touch_downs'];
                                            $matchesRushingAwayArray[$l]['longest_rush'] = (string)$homePlayers['longest_rush'];
                                            $matchesRushingAwayArray[$l]['id'] = (string)$homePlayers['id'];  
                                            $matchesRushingAwayArray[$l]['type'] = 'Rushing';
                                            $l++;

                                        }
                                    }
                                    #############################################
                                    //receiving
                                     if(isset($matches->receiving->hometeam->player)){
                                        
                                        foreach($matches->receiving->hometeam->player as $homePlayers){
                                            $matchesReceivingHomeArray[$m]['name']    = (string)$homePlayers['name'];
                                            $matchesReceivingHomeArray[$m]['total_receptions']     = (string)$homePlayers['total_receptions'];
                                            $matchesReceivingHomeArray[$m]['yards'] = (string)$homePlayers['yards'];
                                            $matchesReceivingHomeArray[$m]['average']    = (string)$homePlayers['average'];
                                            $matchesReceivingHomeArray[$m]['receiving_touch_downs']    = (string)$homePlayers['receiving_touch_downs'];
                                            $matchesReceivingHomeArray[$m]['longest_reception'] = (string)$homePlayers['longest_reception'];
                                            $matchesReceivingHomeArray[$m]['two_pt'] = (string)$homePlayers['two_pt'];
                                            $matchesReceivingHomeArray[$m]['id'] = (string)$homePlayers['id'];  
                                            $matchesReceivingHomeArray[$m]['type'] = 'Receiving';
                                            $m++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->receiving->awayteam->player)){
                                        
                                        foreach($matches->receiving->awayteam->player as $homePlayers){
                                            
                                            $matchesReceivingAwayArray[$n]['name']    = (string)$homePlayers['name'];
                                            $matchesReceivingAwayArray[$n]['total_receptions']     = (string)$homePlayers['total_receptions'];
                                            $matchesReceivingAwayArray[$n]['yards'] = (string)$homePlayers['yards'];
                                            $matchesReceivingAwayArray[$n]['average']    = (string)$homePlayers['average'];
                                            $matchesReceivingAwayArray[$n]['receiving_touch_downs']    = (string)$homePlayers['receiving_touch_downs'];
                                            $matchesReceivingAwayArray[$n]['longest_reception'] = (string)$homePlayers['longest_reception'];
                                            $matchesReceivingAwayArray[$n]['two_pt'] = (string)$homePlayers['two_pt'];
                                            $matchesReceivingAwayArray[$n]['id'] = (string)$homePlayers['id'];  
                                            $matchesReceivingAwayArray[$n]['type'] = 'Receiving';
                                            $n++;

                                        }
                                    }
                                    ###########################################
                                    //fumbles
                                    if(isset($matches->fumbles->hometeam->player)){
                                        
                                        foreach($matches->fumbles->hometeam->player as $homePlayers){
                                            $matchesFumblesHomeArray[$o]['name']    = (string)$homePlayers['name'];
                                            $matchesFumblesHomeArray[$o]['total']     = (string)$homePlayers['total'];
                                            $matchesFumblesHomeArray[$o]['lost'] = (string)$homePlayers['lost'];
                                            $matchesFumblesHomeArray[$o]['rec']    = (string)$homePlayers['rec'];
                                            $matchesFumblesHomeArray[$o]['id'] = (string)$homePlayers['id'];
                                            $matchesFumblesHomeArray[$o]['type'] = 'fumbles';
                                            $o++;

                                        }
                                    }
                                    
                                    if(isset($matches->fumbles->awayteam->player)){
                                        
                                        foreach($matches->fumbles->awayteam->player as $homePlayers){
                                            
                                            $matchesFumblesAwayArray[$p]['name']    = (string)$homePlayers['name'];
                                            $matchesFumblesAwayArray[$p]['total']     = (string)$homePlayers['total'];
                                            $matchesFumblesAwayArray[$p]['lost'] = (string)$homePlayers['lost'];
                                            $matchesFumblesAwayArray[$p]['rec']    = (string)$homePlayers['rec'];
                                            $matchesFumblesAwayArray[$p]['id'] = (string)$homePlayers['id'];
                                            $matchesFumblesAwayArray[$p]['type'] = 'fumbles';
                                            $p++;

                                        }
                                    }
                                    ###########################################
                                    //interceptions
                                     if(isset($matches->interceptions->hometeam->player)){
                                        
                                        foreach($matches->interceptions->hometeam->player as $homePlayers){
                                            $matchesInterceptionsHomeArray[$q]['name']    = (string)$homePlayers['name'];
                                            $matchesInterceptionsHomeArray[$q]['total_interceptions']     = (string)$homePlayers['total_interceptions'];
                                            $matchesInterceptionsHomeArray[$q]['yards'] = (string)$homePlayers['yards'];
                                            $matchesInterceptionsHomeArray[$q]['intercepted_touch_downs']    = (string)$homePlayers['intercepted_touch_downs'];                                            
//                                            $matchesInterceptionsHomeArray[$q]['id'] = (string)$homePlayers['id'];  
                                            $matchesInterceptionsHomeArray[$q]['id'] = (string)$matches->hometeam['id'];
                                            $matchesInterceptionsHomeArray[$q]['type'] = 'interceptions';
                                            $q++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->interceptions->awayteam->player)){
                                        
                                        foreach($matches->interceptions->awayteam->player as $homePlayers){
                                            
                                            $matchesInterceptionsAwayArray[$r]['name']    = (string)$homePlayers['name'];
                                            $matchesInterceptionsAwayArray[$r]['total_interceptions']     = (string)$homePlayers['total_interceptions'];
                                            $matchesInterceptionsAwayArray[$r]['yards'] = (string)$homePlayers['yards'];
                                            $matchesInterceptionsAwayArray[$r]['intercepted_touch_downs']    = (string)$homePlayers['intercepted_touch_downs'];                                            
//                                            $matchesInterceptionsAwayArray[$r]['id'] = (string)$homePlayers['id'];  
                                            $matchesInterceptionsAwayArray[$r]['id'] =  (string)$matches->awayteam['id'];
                                            $matchesInterceptionsAwayArray[$r]['type'] = 'interceptions';
                                            $r++;

                                        }
                                    }
                                    ###########################################
                                    //defensive
                                     if(isset($matches->defensive->hometeam->player)){
                                        
                                        foreach($matches->defensive->hometeam->player as $homePlayers){
                                            $matchesDefensiveHomeArray[$s]['name']    = (string)$homePlayers['name'];
                                            $matchesDefensiveHomeArray[$s]['tackles']     = (string)$homePlayers['tackles'];
                                            $matchesDefensiveHomeArray[$s]['unassisted_tackles'] = (string)$homePlayers['unassisted_tackles'];
                                            $matchesDefensiveHomeArray[$s]['sacks']    = (string)$homePlayers['sacks'];
                                            $matchesDefensiveHomeArray[$s]['tfl']    = (string)$homePlayers['tfl'];
                                            $matchesDefensiveHomeArray[$s]['passes_defended'] = (string)$homePlayers['passes_defended'];
                                            $matchesDefensiveHomeArray[$s]['qb_hts'] = (string)$homePlayers['qb_hts'];
                                            $matchesDefensiveHomeArray[$s]['interceptions_for_touch_downs'] = (string)$homePlayers['interceptions_for_touch_downs'];
//                                            $matchesDefensiveHomeArray[$s]['id'] = (string)$homePlayers['id'];  
                                            $matchesDefensiveHomeArray[$s]['id'] = (string)$matches->hometeam['id'];
                                            $matchesDefensiveHomeArray[$s]['type'] = 'defensive';
                                            $s++;

                                        }
                                    }
                                    
                                    if(isset($matches->defensive->awayteam->player)){
                                        
                                        foreach($matches->defensive->awayteam->player as $homePlayers){
                                            
                                            $matchesDefensiveAwayArray[$s]['name']    = (string)$homePlayers['name'];
                                            $matchesDefensiveAwayArray[$s]['tackles']     = (string)$homePlayers['tackles'];
                                            $matchesDefensiveAwayArray[$s]['unassisted_tackles'] = (string)$homePlayers['unassisted_tackles'];
                                            $matchesDefensiveAwayArray[$s]['sacks']    = (string)$homePlayers['sacks'];
                                            $matchesDefensiveAwayArray[$s]['tfl']    = (string)$homePlayers['tfl'];
                                            $matchesDefensiveAwayArray[$s]['passes_defended'] = (string)$homePlayers['passes_defended'];
                                            $matchesDefensiveAwayArray[$s]['qb_hts'] = (string)$homePlayers['qb_hts'];
                                            $matchesDefensiveAwayArray[$s]['interceptions_for_touch_downs'] = (string)$homePlayers['interceptions_for_touch_downs'];
//                                            $matchesDefensiveAwayArray[$s]['id'] = (string)$homePlayers['id'];  
                                            $matchesDefensiveAwayArray[$s]['id'] = (string)$matches->awayteam['id'];
                                            $matchesDefensiveAwayArray[$s]['type'] = 'defensive';
                                            $n++;

                                        }
                                    }
                                    ############################################
                                    //kick_returns
                                   if(isset($matches->kick_returns->hometeam->player)){
                                        
                                        foreach($matches->kick_returns->hometeam->player as $homePlayers){ 
                                            $matchesKickreturnsHomeArray[$t]['name']    = (string)$homePlayers['name'];
                                            $matchesKickreturnsHomeArray[$t]['total']     = (string)$homePlayers['total'];
                                            $matchesKickreturnsHomeArray[$t]['yards'] = (string)$homePlayers['yards'];
                                            $matchesKickreturnsHomeArray[$t]['average']    = (string)$homePlayers['average'];
                                            $matchesKickreturnsHomeArray[$t]['lg']    = (string)$homePlayers['lg'];
                                            $matchesKickreturnsHomeArray[$t]['td'] = (string)$homePlayers['td'];
//                                            $matchesKickreturnsHomeArray[$t]['id'] = (string)$homePlayers['id'];  
                                            $matchesKickreturnsHomeArray[$t]['id'] = (string)$matches->hometeam['id'];
                                            $matchesKickreturnsHomeArray[$t]['type'] = 'kick_returns';
                                            $t++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->kick_returns->awayteam->player)){
                                        
                                        foreach($matches->kick_returns->awayteam->player as $homePlayers){
                                            
                                            $matchesKickreturnsAwayArray[$t]['name']    = (string)$homePlayers['name'];
                                            $matchesKickreturnsAwayArray[$t]['total']     = (string)$homePlayers['total'];
                                            $matchesKickreturnsAwayArray[$t]['yards'] = (string)$homePlayers['yards'];
                                            $matchesKickreturnsAwayArray[$t]['average']    = (string)$homePlayers['average'];
                                            $matchesKickreturnsAwayArray[$t]['lg']    = (string)$homePlayers['lg'];
                                            $matchesKickreturnsAwayArray[$t]['td'] = (string)$homePlayers['td'];
//                                            $matchesKickreturnsAwayArray[$t]['id'] = (string)$homePlayers['id'];
                                            $matchesKickreturnsAwayArray[$t]['id'] = (string)$matches->awayteam['id'];
                                            $matchesKickreturnsAwayArray[$t]['type'] = 'kick_returns';
                                            $n++;

                                        }
                                    }
                                    #########################################
                                    //put_returns
                                   if(isset($matches->punt_returns->hometeam->player)){
                                        
                                        foreach($matches->punt_returns->hometeam->player as $homePlayers){
                                            $matchesPutreturnsHomeArray[$u]['name']    = (string)$homePlayers['name'];
                                            $matchesPutreturnsHomeArray[$u]['total']     = (string)$homePlayers['total'];
                                            $matchesPutreturnsHomeArray[$u]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPutreturnsHomeArray[$u]['average']    = (string)$homePlayers['average'];
                                            $matchesPutreturnsHomeArray[$u]['lg']    = (string)$homePlayers['lg'];
                                            $matchesPutreturnsHomeArray[$u]['td'] = (string)$homePlayers['td'];
//                                            $matchesPutreturnsHomeArray[$u]['id'] = (string)$homePlayers['id'];  
                                            $matchesPutreturnsHomeArray[$u]['id'] = (string)$matches->hometeam['id'];
                                            $matchesPutreturnsHomeArray[$u]['type'] = 'punt_returns';
                                            $u++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->punt_returns->awayteam->player)){
                                        
                                        foreach($matches->punt_returns->awayteam->player as $homePlayers){
                                            
                                            $matchesPutreturnsAwayArray[$v]['name']    = (string)$homePlayers['name'];
                                            $matchesPutreturnsAwayArray[$v]['total']     = (string)$homePlayers['total'];
                                            $matchesPutreturnsAwayArray[$v]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPutreturnsAwayArray[$v]['average']    = (string)$homePlayers['average'];
                                            $matchesPutreturnsAwayArray[$v]['lg']    = (string)$homePlayers['lg'];
                                            $matchesPutreturnsAwayArray[$v]['td'] = (string)$homePlayers['td'];
//                                            $matchesPutreturnsAwayArray[$v]['id'] = (string)$homePlayers['id'];  
                                            $matchesPutreturnsAwayArray[$v]['id'] = (string)$matches->awayteam['id'];
                                            $matchesPutreturnsAwayArray[$v]['type'] = 'punt_returns';
                                            $v++;

                                        }
                                    }
                                    #########################################
                                    //kicking
                                   if(isset($matches->kicking->hometeam->player)){
                                        
                                        foreach($matches->kicking->hometeam->player as $homePlayers){
                                            $matchesKickingHomeArray[$x]['name']    = (string)$homePlayers['name'];
                                            $matchesKickingHomeArray[$x]['field_goals']     = (string)$homePlayers['field_goals'];
                                            $matchesKickingHomeArray[$x]['pct'] = (string)$homePlayers['pct'];
                                            $matchesKickingHomeArray[$x]['long']    = (string)$homePlayers['long'];
                                            $matchesKickingHomeArray[$x]['extra_point']    = (string)$homePlayers['extra_point'];
                                            $matchesKickingHomeArray[$x]['points'] = (string)$homePlayers['points'];
                                            $matchesKickingHomeArray[$x]['field_goals_from_1_19_yards'] = (string)$homePlayers['field_goals_from_1_19_yards'];  
                                            $matchesKickingHomeArray[$x]['field_goals_from_20_29_yards']    = (string)$homePlayers['field_goals_from_20_29_yards'];
                                            $matchesKickingHomeArray[$x]['field_goals_from_30_39_yards'] = (string)$homePlayers['field_goals_from_30_39_yards'];
                                            $matchesKickingHomeArray[$x]['field_goals_from_40_49_yards'] = (string)$homePlayers['field_goals_from_40_49_yards'];
                                            $matchesKickingHomeArray[$x]['field_goals_from_50_yards'] = (string)$homePlayers['field_goals_from_50_yards'];
//                                            $matchesKickingHomeArray[$x]['id'] = (string)$homePlayers['id']; 
                                            $matchesKickingHomeArray[$x]['id'] = (string)$homePlayers['id'];
                                            $matchesKickingHomeArray[$x]['type'] = 'kicking';
                                            $x++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->kicking->awayteam->player)){
                                        
                                        foreach($matches->kicking->awayteam->player as $homePlayers){
                                            
                                            $matchesKickingAwayArray[$y]['name']    = (string)$homePlayers['name'];
                                            $matchesKickingAwayArray[$y]['field_goals']     = (string)$homePlayers['field_goals'];
                                            $matchesKickingAwayArray[$y]['pct'] = (string)$homePlayers['pct'];
                                            $matchesKickingAwayArray[$y]['long']    = (string)$homePlayers['long'];
                                            $matchesKickingAwayArray[$y]['extra_point']    = (string)$homePlayers['extra_point'];
                                            $matchesKickingAwayArray[$y]['points'] = (string)$homePlayers['points'];
                                            $matchesKickingAwayArray[$y]['field_goals_from_1_19_yards'] = (string)$homePlayers['field_goals_from_1_19_yards'];  
                                            $matchesKickingAwayArray[$y]['field_goals_from_20_29_yards']    = (string)$homePlayers['field_goals_from_20_29_yards'];
                                            $matchesKickingAwayArray[$y]['field_goals_from_30_39_yards'] = (string)$homePlayers['field_goals_from_30_39_yards'];
                                            $matchesKickingAwayArray[$y]['field_goals_from_40_49_yards'] = (string)$homePlayers['field_goals_from_40_49_yards'];
                                            $matchesKickingAwayArray[$y]['field_goals_from_50_yards'] = (string)$homePlayers['field_goals_from_50_yards'];
                                            $matchesKickingAwayArray[$y]['id'] = (string)$homePlayers['id']; 
//                                            $matchesKickingAwayArray[$y]['id'] = (string)$matches->awayteam['id'];
                                            $matchesKickingAwayArray[$y]['type'] = 'kicking';
                                            $y++;

                                        }
                                    }
                                    #########################################
                                    //punting
                                   if(isset($matches->punting->hometeam->player)){
                                        
                                        foreach($matches->punting->hometeam->player as $homePlayers){
                                            $matchesPuntingHomeArray[$z]['name']    = (string)$homePlayers['name'];
                                            $matchesPuntingHomeArray[$z]['total']     = (string)$homePlayers['total'];
                                            $matchesPuntingHomeArray[$z]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPuntingHomeArray[$z]['average']    = (string)$homePlayers['average'];
                                            $matchesPuntingHomeArray[$z]['touchbacks']    = (string)$homePlayers['touchbacks'];
                                            $matchesPuntingHomeArray[$z]['in20'] = (string)$homePlayers['in20'];
                                            $matchesPuntingHomeArray[$z]['lg'] = (string)$homePlayers['lg'];
                                            $matchesPuntingHomeArray[$z]['id'] = (string)$homePlayers['id']; 
                                            $matchesPuntingHomeArray[$z]['type'] = 'punting';
                                            $z++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->punting->awayteam->player)){
                                        
                                        foreach($matches->punting->awayteam->player as $homePlayers){
                                            
                                            $matchesPuntingAwayArray[$z1]['name']    = (string)$homePlayers['name'];
                                            $matchesPuntingAwayArray[$z1]['total']     = (string)$homePlayers['total'];
                                            $matchesPuntingAwayArray[$z1]['yards'] = (string)$homePlayers['yards'];
                                            $matchesPuntingAwayArray[$z1]['average']    = (string)$homePlayers['average'];
                                            $matchesPuntingAwayArray[$z1]['touchbacks']    = (string)$homePlayers['touchbacks'];
                                            $matchesPuntingAwayArray[$z1]['in20'] = (string)$homePlayers['in20'];
                                            $matchesPuntingAwayArray[$z1]['lg'] = (string)$homePlayers['lg'];
                                            $matchesPuntingAwayArray[$z1]['id'] = (string)$homePlayers['id']; 
                                            $matchesPuntingAwayArray[$z1]['type'] = 'punting';
                                            $z1++;

                                        }
                                    }                              
                                    
                                }
                                ################################################
                                 
//                                if(!empty($matchesPassingHomeArray) && !empty($matchesPassingAwayArray) 
//                                        && !empty($matchesRushingHomeArray) && !empty($matchesRushingAwayArray) 
//                                        && !empty($matchesReceivingHomeArray) && !empty($matchesReceivingAwayArray)
//                                        && !empty($matchesFumblesHomeArray)&& !empty($matchesFumblesAwayArray)
//                                        && !empty($matchesInterceptionsHomeArray)&& !empty($matchesInterceptionsAwayArray)
//                                        && !empty($matchesDefensiveHomeArray)&& !empty($matchesDefensiveAwayArray)
//                                        && !empty($matchesKickreturnsHomeArray)&& !empty($matchesKickreturnsAwayArray)
//                                        && !empty($matchesPutreturnsHomeArray)&& !empty($matchesPutreturnsAwayArray)
//                                        && !empty($matchesKickingHomeArray)&& !empty($matchesKickingAwayArray)
//                                        && !empty($matchesPuntingHomeArray)&& !empty($matchesPuntingAwayArray)

//                                  )
//                                {
                                        $mergeArray = array_merge($matchesPassingHomeArray,
                                                $matchesPassingAwayArray,
                                                $matchesRushingHomeArray,
                                                $matchesRushingAwayArray,
                                                $matchesReceivingHomeArray,
                                                $matchesReceivingAwayArray,
                                                $matchesFumblesHomeArray,
                                                $matchesFumblesAwayArray,
                                                $matchesInterceptionsHomeArray,
                                                $matchesInterceptionsAwayArray,
                                                $matchesDefensiveHomeArray,
                                                $matchesDefensiveAwayArray,
                                                $matchesKickreturnsHomeArray,
                                                $matchesKickreturnsAwayArray,
                                                $matchesPutreturnsHomeArray,
                                                $matchesPutreturnsAwayArray,
                                                $matchesKickingHomeArray,
                                                $matchesKickingAwayArray,
                                                $matchesPuntingHomeArray,
                                                $matchesPuntingAwayArray,
                                                $teamStatsAwayArray,
                                                $teamStatsHomeArray
                                                );    
//                                }
//                             echo "<pre>"; print_r($mergeArray); echo "</pre>"; die;      
                            if(isset($mergeArray)){
                                return $mergeArray;
                            }
                        }
                        break;
                    case 'MLB':
//                        $matchDate = "08.04.2015";
                        $MLB = "http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/baseball/usa?date=".$matchDate;                        
//                        echo $MLB;//die('test');
                        $client = new Zend_Http_Client($MLB);
                        $response = $client->request();
                        $data = $this->xmlLoad($response);
//                        echo "<pre>"; print_r($data); die;
                        $matchesArray = array();
                        $matchesHitterHomeArray = array();
                        $matchesHitterAwayArray = array();
                        $matchesPitcherHomeArray = array();
                        $matchesPitcherAwayArray = array();
                        $matchesStartingHomePitchersArray = array();
                        $matchesStartingAwayPitchersArray = array();
                        
                        if(isset($data->category->match)){
                            
                            $i = 0;$j = 0;$k = 0;$l = 0;$m = 0;$n = 0;
                            
                                foreach($data->category->match as $matches){

//                                    $matchDate          = (string)$matches['date'];
//                                    $matchTimezone      = (string)$matches['timezone'];
//                                    $matchStatus        = (string)$matches['status'];
//                                    $matchFormattedDate = (string)$matches['formatted_date'];
//                                    $gameouts           = (string)$data['outs'];
//                                    $gameCategoryId     = (string)$data['id'];
                                    //print"<pre>";print_r($matches);print"</pre>";die; 
                                    if(isset($matches->stats->hitters->hometeam->player)){
                                    
                                        foreach($matches->stats->hitters->hometeam->player as $homePlayers){

                                            $matchesHitterHomeArray[$i]['name']    = (string)$homePlayers['name'];
                                            $matchesHitterHomeArray[$i]['pos']     = (string)$homePlayers['pos'];
                                            $matchesHitterHomeArray[$i]['at_bats'] = (string)$homePlayers['at_bats'];
                                            $matchesHitterHomeArray[$i]['runs']    = (string)$homePlayers['runs'];
                                            $matchesHitterHomeArray[$i]['hits']    = (string)$homePlayers['hits'];
                                            $matchesHitterHomeArray[$i]['doubles'] = (string)$homePlayers['doubles'];
                                            $matchesHitterHomeArray[$i]['triples'] = (string)$homePlayers['triples'];
                                            $matchesHitterHomeArray[$i]['home_run'] = (string)$homePlayers['home_runs'];
                                            $matchesHitterHomeArray[$i]['sac_fly'] = (string)$homePlayers['sac_fly'];
                                            $matchesHitterHomeArray[$i]['hit_by_pitch'] = (string)$homePlayers['hit_by_pitch'];
                                            $matchesHitterHomeArray[$i]['runs_batted_in'] = (string)$homePlayers['runs_batted_in'];
                                            $matchesHitterHomeArray[$i]['walks'] = (string)$homePlayers['walks'];
                                            $matchesHitterHomeArray[$i]['hitter_strikeouts'] = (string)$homePlayers['strikeouts'];
                                            $matchesHitterHomeArray[$i]['average'] = (string)$homePlayers['average'];
                                            $matchesHitterHomeArray[$i]['stolen_bases'] = (string)$homePlayers['stolen_bases'];
                                            $matchesHitterHomeArray[$i]['on_base_percentage'] = (string)$homePlayers['on_base_percentage'];
                                            $matchesHitterHomeArray[$i]['slugging_percentage'] = (string)$homePlayers['slugging_percentage'];
                                            $matchesHitterHomeArray[$i]['id'] = (string)$homePlayers['id'];
                                            $matchesHitterHomeArray[$i]['team_id'] = (string)$matches->hometeam['id'];
                                            $matchesHitterHomeArray[$i]['type'] = 'hitters';
                                            $i++;

                                        }
                                    }
                                    
                                    if(isset($matches->stats->hitters->awayteam->player)){
                                        
                                        foreach($matches->stats->hitters->awayteam->player as $awayPlayers){
                                            $matchesHitterAwayArray[$j]['name'] = (string)$awayPlayers['name'];
                                            $matchesHitterAwayArray[$j]['pos'] = (string)$awayPlayers['pos'];
                                            $matchesHitterAwayArray[$j]['at_bats'] = (string)$awayPlayers['at_bats'];
                                            $matchesHitterAwayArray[$j]['runs'] = (string)$awayPlayers['runs'];
                                            $matchesHitterAwayArray[$j]['hits'] = (string)$awayPlayers['hits'];
                                            $matchesHitterAwayArray[$j]['doubles'] = (string)$awayPlayers['doubles'];
                                            $matchesHitterAwayArray[$j]['triples'] = (string)$awayPlayers['triples'];
                                            $matchesHitterAwayArray[$j]['home_run'] = (string)$awayPlayers['home_runs'];
                                            $matchesHitterAwayArray[$j]['sac_fly'] = (string)$awayPlayers['sac_fly'];
                                            $matchesHitterAwayArray[$j]['hit_by_pitch'] = (string)$awayPlayers['hit_by_pitch'];
                                            $matchesHitterAwayArray[$j]['runs_batted_in'] = (string)$awayPlayers['runs_batted_in'];
                                            $matchesHitterAwayArray[$j]['walks'] = (string)$awayPlayers['walks'];
                                            $matchesHitterAwayArray[$j]['hitter_strikeouts'] = (string)$awayPlayers['strikeouts'];
                                            $matchesHitterAwayArray[$j]['average'] = (string)$awayPlayers['average'];
                                            $matchesHitterAwayArray[$j]['stolen_bases'] = (string)$awayPlayers['stolen_bases'];
                                            $matchesHitterAwayArray[$j]['on_base_percentage'] = (string)$awayPlayers['on_base_percentage'];
                                            $matchesHitterAwayArray[$j]['slugging_percentage'] = (string)$awayPlayers['slugging_percentage'];
                                            $matchesHitterAwayArray[$j]['id'] = (string)$awayPlayers['id']; 
                                            $matchesHitterAwayArray[$j]['team_id'] = (string)$matches->awayteam['id'];
                                            $matchesHitterAwayArray[$j]['type'] = 'hitters';
                                            $j++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->stats->pitchers->hometeam->player)){
                                        
                                        foreach($matches->stats->pitchers->hometeam->player as $homePlayers){
                                            $matchesPitcherHomeArray[$k]['name'] = (string)$homePlayers['name'];
                                            $matchesPitcherHomeArray[$k]['innings_pitched'] = (string)$homePlayers['innings_pitched'];
                                            $matchesPitcherHomeArray[$k]['runs'] = (string)$homePlayers['runs'];
                                            $matchesPitcherHomeArray[$k]['hits'] = (string)$homePlayers['hits'];
                                            $matchesPitcherHomeArray[$k]['earned_runs'] = (string)$homePlayers['earned_runs'];
                                            $matchesPitcherHomeArray[$k]['walks'] = (string)$homePlayers['walks'];
                                            $matchesPitcherHomeArray[$k]['strikeouts'] = (string)$homePlayers['strikeouts'];
                                            $matchesPitcherHomeArray[$k]['home_runs'] = (string)$homePlayers['home_runs'];
                                            $matchesPitcherHomeArray[$k]['pc-st'] = (string)$homePlayers['pc-st'];
                                            $matchesPitcherHomeArray[$k]['earned_runs_average'] = (string)$homePlayers['earned_runs_average'];
                                            $matchesPitcherHomeArray[$k]['win'] = (string)$homePlayers['win'];
                                            $matchesPitcherHomeArray[$k]['loss'] = (string)$homePlayers['loss'];
                                            $matchesPitcherHomeArray[$k]['holds'] = (string)$homePlayers['holds'];
                                            $matchesPitcherHomeArray[$k]['saves'] = (string)$homePlayers['saves'];
                                            $matchesPitcherHomeArray[$k]['id'] = (string)$homePlayers['id'];  
                                            $matchesPitcherHomeArray[$k]['team_id'] = (string)$matches->hometeam['id'];
                                            $matchesPitcherHomeArray[$k]['type'] = 'pitchers';
                                            $k++;

                                        }
                                    }
                                    
                                    
                                    if(isset($matches->stats->pitchers->awayteam->player)){
                                        
                                        foreach($matches->stats->pitchers->awayteam->player as $homePlayers){
                                            $matchesPitcherAwayArray[$l]['name'] = (string)$homePlayers['name'];
                                            $matchesPitcherAwayArray[$l]['innings_pitched'] = (string)$homePlayers['innings_pitched'];
                                            $matchesPitcherAwayArray[$l]['runs'] = (string)$homePlayers['runs'];
                                            $matchesPitcherAwayArray[$l]['hits'] = (string)$homePlayers['hits'];
                                            $matchesPitcherAwayArray[$l]['earned_runs'] = (string)$homePlayers['earned_runs'];
                                            $matchesPitcherAwayArray[$l]['walks'] = (string)$homePlayers['walks'];
                                            $matchesPitcherAwayArray[$l]['strikeouts'] = (string)$homePlayers['strikeouts'];
                                            $matchesPitcherAwayArray[$l]['home_runs'] = (string)$homePlayers['home_runs'];
                                            $matchesPitcherAwayArray[$l]['pc-st'] = (string)$homePlayers['pc-st'];
                                            $matchesPitcherAwayArray[$l]['earned_runs_average'] = (string)$homePlayers['earned_runs_average'];
                                            $matchesPitcherAwayArray[$l]['win'] = (string)$homePlayers['win'];
                                            $matchesPitcherAwayArray[$l]['loss'] = (string)$homePlayers['loss'];
                                            $matchesPitcherAwayArray[$l]['holds'] = (string)$homePlayers['holds'];
                                            $matchesPitcherAwayArray[$l]['saves'] = (string)$homePlayers['saves'];
                                            $matchesPitcherAwayArray[$l]['id'] = (string)$homePlayers['id']; 
                                            $matchesPitcherAwayArray[$l]['team_id'] = (string)$matches->awayteam['id'];
                                            $matchesPitcherAwayArray[$l]['type'] = 'pitchers';
                                            $l++;

                                        }
                                    }
                                    
                                    
                                    
                                   
                                    $matchesStartingHomePitchersArray[$m]['name'] = (string)$matches->starting_pitchers->hometeam->player['name'];
                                    $matchesStartingHomePitchersArray[$m]['id']   = (string)$matches->starting_pitchers->hometeam->player['id'];
                                    $matchesStartingHomePitchersArray[$m]['type'] = 'starting_pitchers';
                                    $m++;
                                    $matchesStartingAwayPitchersArray[$n]['name'] = (string)$matches->starting_pitchers->hometeam->player['name'];
                                    $matchesStartingAwayPitchersArray[$n]['id']   = (string)$matches->starting_pitchers->hometeam->player['id'];
                                    $matchesStartingAwayPitchersArray[$n]['type'] = 'starting_pitchers';
                                    $n++;
                                    
                                } 
                                    //if(!empty($matchesHitterHomeArray) && !empty($matchesHitterAwayArray) && !empty($matchesPitcherHomeArray) && !empty($matchesPitcherAwayArray) && !empty($matchesStartingHomePitchersArray) && !empty($matchesStartingAwayPitchersArray)){
                                        $mergeArray = array_merge($matchesHitterHomeArray,$matchesHitterAwayArray,$matchesPitcherHomeArray,$matchesPitcherAwayArray);    
                                    //}
                                    //echo "<pre>"; print_r($mergeArray); echo "</pre>"; die;
                                    if(isset($mergeArray)){
                                        return $mergeArray;
                                    }
                        }
                        break;
                    case 'NBA': 
                        $NBA = "http://www.goalserve.com/getfeed/967429e9f839499da2b7ecc96b335bf7/bsktbl/nba-scores?date=".$matchDate;
                        $client = new Zend_Http_Client($NBA); 
                        $response = $client->request();
                        $data = $this->xmlLoad($response);
                        $playerStatsDetails = array();
//                        echo "<pre>"; print_r($data); echo "</pre>"; die;
                        if (isset($data->category->match)) {
                        foreach ($data->category->match as $catMatch) {

//echo "<pre>"; print_r($catMatch); echo "</pre>";
                            if (isset($catMatch->player_stats) && !empty($catMatch->player_stats)) {

                                $homeStarterPlayerArray = array();
                                $homeBenchPlayersArray = array();
                                $awayStartersPlayerArray = array();
                                $awayBenchPlayerArray = array();
                                $i = 0;
                                $j = 0;
                                $k = 0;
                                $l = 0;

                                foreach ($catMatch->player_stats as $playerStats) {
//echo "<pre>"; print_r($playerStats); echo "</pre>"; die;
                                    foreach ($playerStats->hometeam->starters->player as $homeStarterPlayers) {

                                        $homeStarterPlayerArray[$i]['name'] = (string) $homeStarterPlayers['name'];
                                        $homeStarterPlayerArray[$i]['pos'] = (string) $homeStarterPlayers['pos'];
                                        $homeStarterPlayerArray[$i]['minutes'] = (string) $homeStarterPlayers['minutes'];
                                        $homeStarterPlayerArray[$i]['field_goals_made'] = (string) $homeStarterPlayers['field_goals_made'];
                                        $homeStarterPlayerArray[$i]['field_goals_attempts'] = (string) $homeStarterPlayers['field_goals_attempts'];
                                        $homeStarterPlayerArray[$i]['threepoint_goals_made'] = (string) $homeStarterPlayers['threepoint_goals_made'];
                                        $homeStarterPlayerArray[$i]['threepoint_goals_attempts'] = (string) $homeStarterPlayers['threepoint_goals_attempts'];
                                        $homeStarterPlayerArray[$i]['freethrows_goals_made'] = (string) $homeStarterPlayers['freethrows_goals_made'];
                                        $homeStarterPlayerArray[$i]['freethrows_goals_attempts'] = (string) $homeStarterPlayers['freethrows_goals_attempts'];
                                        $homeStarterPlayerArray[$i]['offence_rebounds'] = (string) $homeStarterPlayers['offence_rebounds'];
                                        $homeStarterPlayerArray[$i]['defense_rebounds'] = (string) $homeStarterPlayers['defense_rebounds'];
                                        $homeStarterPlayerArray[$i]['total_rebounds'] = (string) $homeStarterPlayers['total_rebounds'];
                                        $homeStarterPlayerArray[$i]['assists'] = (string) $homeStarterPlayers['assists'];
                                        $homeStarterPlayerArray[$i]['steals'] = (string) $homeStarterPlayers['steals'];
                                        $homeStarterPlayerArray[$i]['blocks'] = (string) $homeStarterPlayers['blocks'];
                                        $homeStarterPlayerArray[$i]['turnovers'] = (string) $homeStarterPlayers['turnovers'];
                                        $homeStarterPlayerArray[$i]['personal_fouls'] = (string) $homeStarterPlayers['personal_fouls'];
                                        $homeStarterPlayerArray[$i]['plus_minus'] = (string) $homeStarterPlayers['plus_minus'];
                                        $homeStarterPlayerArray[$i]['points'] = (string) $homeStarterPlayers['points'];
                                        $homeStarterPlayerArray[$i]['id'] = (string) $homeStarterPlayers['id'];
                                        $homeStarterPlayerArray[$i]['type'] = 'starters';
                                        $i++;
                                    }

                                    foreach ($playerStats->hometeam->bench->player as $homeBenchPlayers) {
                                        $homeBenchPlayersArray[$j]['name'] = (string) $homeBenchPlayers['name'];
                                        $homeBenchPlayersArray[$j]['pos'] = (string) $homeBenchPlayers['pos'];
                                        $homeBenchPlayersArray[$j]['minutes'] = (string) $homeBenchPlayers['minutes'];
                                        $homeBenchPlayersArray[$j]['field_goals_made'] = (string) $homeBenchPlayers['field_goals_made'];
                                        $homeBenchPlayersArray[$j]['field_goals_attempts'] = (string) $homeBenchPlayers['field_goals_attempts'];
                                        $homeBenchPlayersArray[$j]['threepoint_goals_made'] = (string) $homeBenchPlayers['threepoint_goals_made'];
                                        $homeBenchPlayersArray[$j]['threepoint_goals_attempts'] = (string) $homeBenchPlayers['threepoint_goals_attempts'];
                                        $homeBenchPlayersArray[$j]['freethrows_goals_made'] = (string) $homeBenchPlayers['freethrows_goals_made'];
                                        $homeBenchPlayersArray[$j]['freethrows_goals_attempts'] = (string) $homeBenchPlayers['freethrows_goals_attempts'];
                                        $homeBenchPlayersArray[$j]['offence_rebounds'] = (string) $homeBenchPlayers['offence_rebounds'];
                                        $homeBenchPlayersArray[$j]['defense_rebounds'] = (string) $homeBenchPlayers['defense_rebounds'];
                                        $homeBenchPlayersArray[$j]['total_rebounds'] = (string) $homeBenchPlayers['total_rebounds'];
                                        $homeBenchPlayersArray[$j]['assists'] = (string) $homeBenchPlayers['assists'];
                                        $homeBenchPlayersArray[$j]['steals'] = (string) $homeBenchPlayers['steals'];
                                        $homeBenchPlayersArray[$j]['blocks'] = (string) $homeBenchPlayers['blocks'];
                                        $homeBenchPlayersArray[$j]['turnovers'] = (string) $homeBenchPlayers['turnovers'];
                                        $homeBenchPlayersArray[$j]['personal_fouls'] = (string) $homeBenchPlayers['personal_fouls'];
                                        $homeBenchPlayersArray[$j]['plus_minus'] = (string) $homeBenchPlayers['plus_minus'];
                                        $homeBenchPlayersArray[$j]['points'] = (string) $homeBenchPlayers['points'];
                                        $homeBenchPlayersArray[$j]['id'] = (string) $homeBenchPlayers['id'];
                                        $homeBenchPlayersArray[$j]['type'] = 'bench';
                                        $j++;
                                    }

                                    foreach ($playerStats->awayteam->starters->player as $awayStartersPlayers) {

                                        $awayStartersPlayerArray[$k]['name'] = (string) $awayStartersPlayers['name'];
                                        $awayStartersPlayerArray[$k]['pos'] = (string) $awayStartersPlayers['pos'];
                                        $awayStartersPlayerArray[$k]['minutes'] = (string) $awayStartersPlayers['minutes'];
                                        $awayStartersPlayerArray[$k]['field_goals_made'] = (string) $awayStartersPlayers['field_goals_made'];
                                        $awayStartersPlayerArray[$k]['field_goals_attempts'] = (string) $awayStartersPlayers['field_goals_attempts'];
                                        $awayStartersPlayerArray[$k]['threepoint_goals_made'] = (string) $awayStartersPlayers['threepoint_goals_made'];
                                        $awayStartersPlayerArray[$k]['threepoint_goals_attempts'] = (string) $awayStartersPlayers['threepoint_goals_attempts'];
                                        $awayStartersPlayerArray[$k]['freethrows_goals_made'] = (string) $awayStartersPlayers['freethrows_goals_made'];
                                        $awayStartersPlayerArray[$k]['freethrows_goals_attempts'] = (string) $awayStartersPlayers['freethrows_goals_attempts'];
                                        $awayStartersPlayerArray[$k]['offence_rebounds'] = (string) $awayStartersPlayers['offence_rebounds'];
                                        $awayStartersPlayerArray[$k]['defense_rebounds'] = (string) $awayStartersPlayers['defense_rebounds'];
                                        $awayStartersPlayerArray[$k]['total_rebounds'] = (string) $awayStartersPlayers['total_rebounds'];
                                        $awayStartersPlayerArray[$k]['assists'] = (string) $awayStartersPlayers['assists'];
                                        $awayStartersPlayerArray[$k]['steals'] = (string) $awayStartersPlayers['steals'];
                                        $awayStartersPlayerArray[$k]['blocks'] = (string) $awayStartersPlayers['blocks'];
                                        $awayStartersPlayerArray[$k]['turnovers'] = (string) $awayStartersPlayers['turnovers'];
                                        $awayStartersPlayerArray[$k]['personal_fouls'] = (string) $awayStartersPlayers['personal_fouls'];
                                        $awayStartersPlayerArray[$k]['plus_minus'] = (string) $awayStartersPlayers['plus_minus'];
                                        $awayStartersPlayerArray[$k]['points'] = (string) $awayStartersPlayers['points'];
                                        $awayStartersPlayerArray[$k]['id'] = (string) $awayStartersPlayers['id'];
                                        $awayStartersPlayerArray[$k]['type'] = 'starters';
                                        $k++;
                                    }

                                    foreach ($playerStats->awayteam->bench->player as $awayBenchPlayers) {

                                        $awayBenchPlayerArray[$l]['name'] = (string) $awayBenchPlayers['name'];
                                        $awayBenchPlayerArray[$l]['pos'] = (string) $awayBenchPlayers['pos'];
                                        $awayBenchPlayerArray[$l]['minutes'] = (string) $awayBenchPlayers['minutes'];
                                        $awayBenchPlayerArray[$l]['field_goals_made'] = (string) $awayBenchPlayers['field_goals_made'];
                                        $awayBenchPlayerArray[$l]['field_goals_attempts'] = (string) $awayBenchPlayers['field_goals_attempts'];
                                        $awayBenchPlayerArray[$l]['threepoint_goals_made'] = (string) $awayBenchPlayers['threepoint_goals_made'];
                                        $awayBenchPlayerArray[$l]['threepoint_goals_attempts'] = (string) $awayBenchPlayers['threepoint_goals_attempts'];
                                        $awayBenchPlayerArray[$l]['freethrows_goals_made'] = (string) $awayBenchPlayers['freethrows_goals_made'];
                                        $awayBenchPlayerArray[$l]['freethrows_goals_attempts'] = (string) $awayBenchPlayers['freethrows_goals_attempts'];
                                        $awayBenchPlayerArray[$l]['offence_rebounds'] = (string) $awayBenchPlayers['offence_rebounds'];
                                        $awayBenchPlayerArray[$l]['defense_rebounds'] = (string) $awayBenchPlayers['defense_rebounds'];
                                        $awayBenchPlayerArray[$l]['total_rebounds'] = (string) $awayBenchPlayers['total_rebounds'];
                                        $awayBenchPlayerArray[$l]['assists'] = (string) $awayBenchPlayers['assists'];
                                        $awayBenchPlayerArray[$l]['steals'] = (string) $awayBenchPlayers['steals'];
                                        $awayBenchPlayerArray[$l]['blocks'] = (string) $awayBenchPlayers['blocks'];
                                        $awayBenchPlayerArray[$l]['turnovers'] = (string) $awayBenchPlayers['turnovers'];
                                        $awayBenchPlayerArray[$l]['personal_fouls'] = (string) $awayBenchPlayers['personal_fouls'];
                                        $awayBenchPlayerArray[$l]['plus_minus'] = (string) $awayBenchPlayers['plus_minus'];
                                        $awayBenchPlayerArray[$l]['points'] = (string) $awayBenchPlayers['points'];
                                        $awayBenchPlayerArray[$l]['id'] = (string) $awayBenchPlayers['id'];
                                        $awayBenchPlayerArray[$l]['type'] = 'bench';
                                        $l++;
                                    }
                                
                                   if (!empty($homeStarterPlayerArray) && !empty($homeBenchPlayersArray) && !empty($awayStartersPlayerArray) && !empty($awayBenchPlayerArray)) {
                                        $mergeArray = array_merge($homeStarterPlayerArray, $homeBenchPlayersArray, $awayStartersPlayerArray, $awayBenchPlayerArray);
                                    } 
//                                    echo "<pre>"; print_r($mergeArray); echo "</pre>"; die;
                                    if(!empty($mergeArray)){
                                        array_walk($mergeArray, function($value) use(&$playerStatsDetails){
                                            array_push($playerStatsDetails, $value);
                                        });
                                    }
                                }
                            }
                        }
                         
                        if ($playerStatsDetails) {
                            return $playerStatsDetails;
                        }
                    }
                        break;
                    /**
                    * Developer    : Vivek Chaudhari
                    * Description  : get NHL game result details
                    * Date         : 18/10/2014
                    * @return      : <array> player list details with result points
                    */    
                    case 'NHL':
                            $NHL = "http://www.goalserve.com/getfeed/aee0ca80d72d4a548e0fa8cd391bc66d/hockey/nhl-scores?date=".$matchDate;
                            $client = new Zend_Http_Client($NHL);
                            $response = $client->request();
                            $data = $this->xmlLoad($response);
                            
                            if(isset($data->category->match)){
                                $homePlayersArray = array();
                                $awayPlayersArray = array();
                                $homeGoalKiArray = array();
                                $awayGoalkiArray = array();
                                $i=0; $j=0; $k=0; $l=0;
                                foreach($data->category->match as $match){
                                    if(isset($match->player_stats->hometeam->player)){
                                        foreach($match->player_stats->hometeam->player as $homePlayers){
                                            $homePlayersArray[$i]['name'] = (string)$homePlayers['name'];
                                            $homePlayersArray[$i]['pos'] = (string)$homePlayers['pos'];
                                            $homePlayersArray[$i]['goals'] = (string)$homePlayers['goals'];
                                            $homePlayersArray[$i]['assists'] = (string)$homePlayers['assists'];
                                            $homePlayersArray[$i]['pp_goals'] = (string)$homePlayers['pp_goals'];
                                            $homePlayersArray[$i]['pp_assists'] = (string)$homePlayers['pp_assists'];
                                            $homePlayersArray[$i]['sh_goals'] = (string)$homePlayers['sh_goals'];
                                            $homePlayersArray[$i]['sh_assists'] = (string)$homePlayers['sh_assists'];
                                            $homePlayersArray[$i]['plus_minus'] = (string)$homePlayers['plus_minus'];
                                            $homePlayersArray[$i]['shots_on_goal'] = (string)$homePlayers['shots_on_goal'];
                                            $homePlayersArray[$i]['missed_shots'] = (string)$homePlayers['missed_shots'];
                                            $homePlayersArray[$i]['blocked_shots'] = (string)$homePlayers['blocked_shots'];
                                            $homePlayersArray[$i]['penalties'] = (string)$homePlayers['penalties'];
                                            $homePlayersArray[$i]['penalty_minutes'] = (string)$homePlayers['penalty_minutes'];
                                            $homePlayersArray[$i]['hits'] = (string)$homePlayers['hits'];
                                            $homePlayersArray[$i]['takeaways'] = (string)$homePlayers['takeaways'];
                                            $homePlayersArray[$i]['giveaways'] = (string)$homePlayers['giveaways'];
                                            $homePlayersArray[$i]['shitfs'] = (string)$homePlayers['shitfs'];
                                            $homePlayersArray[$i]['time_on_ice'] = (string)$homePlayers['time_on_ice'];
                                            $homePlayersArray[$i]['power_play'] = (string)$homePlayers['power_play'];
                                            $homePlayersArray[$i]['short_handed_time_on_id'] = (string)$homePlayers['short_handed_time_on_id'];
                                            $homePlayersArray[$i]['even_strength_time_on_ice'] = (string)$homePlayers['even_strength_time_on_ice'];
                                            $homePlayersArray[$i]['faceoffs_won'] = (string)$homePlayers['faceoffs_won'];
                                            $homePlayersArray[$i]['faceoffs_lost'] = (string)$homePlayers['faceoffs_lost'];
                                            $homePlayersArray[$i]['faceoffs_pct'] = (string)$homePlayers['faceoffs_pct'];
                                            $homePlayersArray[$i]['type'] = 'player';
                                            $homePlayersArray[$i]['id'] = (string)$homePlayers['id'];
                                            $i++;
                                        }
                                    }
                                    if(isset($match->player_stats->awayteam->player)){
                                        foreach($match->player_stats->awayteam->player as $awayPlayers){
                                            $awayPlayersArray[$j]['name'] = (string)$awayPlayers['name'];
                                            $awayPlayersArray[$j]['pos'] = (string)$awayPlayers['pos'];
                                            $awayPlayersArray[$j]['goals'] = (string)$awayPlayers['goals'];
                                            $awayPlayersArray[$j]['assists'] = (string)$awayPlayers['assists'];
                                            $awayPlayersArray[$j]['pp_goals'] = (string)$awayPlayers['pp_goals'];
                                            $awayPlayersArray[$j]['pp_assists'] = (string)$awayPlayers['pp_assists'];
                                            $awayPlayersArray[$j]['sh_goals'] = (string)$awayPlayers['sh_goals'];
                                            $awayPlayersArray[$j]['sh_assists'] = (string)$awayPlayers['sh_assists'];
                                            $awayPlayersArray[$j]['plus_minus'] = (string)$awayPlayers['plus_minus'];
                                            $awayPlayersArray[$j]['shots_on_goal'] = (string)$awayPlayers['shots_on_goal'];
                                            $awayPlayersArray[$j]['missed_shots'] = (string)$awayPlayers['missed_shots'];
                                            $awayPlayersArray[$j]['blocked_shots'] = (string)$awayPlayers['blocked_shots'];
                                            $awayPlayersArray[$j]['penalties'] = (string)$awayPlayers['penalties'];
                                            $awayPlayersArray[$j]['penalty_minutes'] = (string)$awayPlayers['penalty_minutes'];
                                            $awayPlayersArray[$j]['hits'] = (string)$awayPlayers['hits'];
                                            $awayPlayersArray[$j]['takeaways'] = (string)$awayPlayers['takeaways'];
                                            $awayPlayersArray[$j]['giveaways'] = (string)$awayPlayers['giveaways'];
                                            $awayPlayersArray[$j]['shitfs'] = (string)$awayPlayers['shitfs'];
                                            $awayPlayersArray[$j]['time_on_ice'] = (string)$awayPlayers['time_on_ice'];
                                            $awayPlayersArray[$j]['power_play'] = (string)$awayPlayers['power_play'];
                                            $awayPlayersArray[$j]['short_handed_time_on_id'] = (string)$awayPlayers['short_handed_time_on_id'];
                                            $awayPlayersArray[$j]['even_strength_time_on_ice'] = (string)$awayPlayers['even_strength_time_on_ice'];
                                            $awayPlayersArray[$j]['faceoffs_won'] = (string)$awayPlayers['faceoffs_won'];
                                            $awayPlayersArray[$j]['faceoffs_lost'] = (string)$awayPlayers['faceoffs_lost'];
                                            $awayPlayersArray[$j]['faceoffs_pct'] = (string)$awayPlayers['faceoffs_pct'];
                                            $awayPlayersArray[$j]['type'] = 'player';
                                            $awayPlayersArray[$j]['id'] = (string)$awayPlayers['id'];
                                            $j++;
                                        }
                                    }
                                    if(isset($match->goalkeeper_stats->hometeam->player)){
                                        foreach($match->goalkeeper_stats->hometeam->player as $homeGolki){
                                            $homeGoalKiArray[$k]['name'] = (string)$homeGolki['name'];
                                            $homeGoalKiArray[$k]['shots_against'] = (string)$homeGolki['shots_against'];
                                            $homeGoalKiArray[$k]['goals_against'] = (string)$homeGolki['goals_against'];
                                            $homeGoalKiArray[$k]['saves'] = (string)$homeGolki['saves'];
                                            $homeGoalKiArray[$k]['saves_pct'] = (string)$homeGolki['saves_pct'];
                                            $homeGoalKiArray[$k]['time_on_ice'] = (string)$homeGolki['time_on_ice'];
                                            $homeGoalKiArray[$k]['penalty_minutes'] = (string)$homeGolki['penalty_minutes'];
                                            $homeGoalKiArray[$k]['credit'] = (string)$homeGolki['credit'];
                                            $homeGoalKiArray[$k]['so'] = (string)$match->hometeam['so'];
                                            $homeGoalKiArray[$k]['type'] = 'goalkeeper';
                                            $homeGoalKiArray[$k]['id'] = (string)$homeGolki['id'];
                                            $k++;
                                        }
                                    }
                                    if(isset($match->goalkeeper_stats->awayteam->player)){
                                        foreach($match->goalkeeper_stats->awayteam->player as $awayGolki){
                                            $awayGoalkiArray[$l]['name'] = (string)$awayGolki['name'];
                                            $awayGoalkiArray[$l]['shots_against'] = (string)$awayGolki['shots_against'];
                                            $awayGoalkiArray[$l]['goals_against'] = (string)$awayGolki['goals_against'];
                                            $awayGoalkiArray[$l]['saves'] = (string)$awayGolki['saves'];
                                            $awayGoalkiArray[$l]['saves_pct'] = (string)$awayGolki['saves_pct'];
                                            $awayGoalkiArray[$l]['time_on_ice'] = (string)$awayGolki['time_on_ice'];
                                            $awayGoalkiArray[$l]['penalty_minutes'] = (string)$awayGolki['penalty_minutes'];
                                            $awayGoalkiArray[$l]['credit'] = (string)$awayGolki['credit'];
                                            $awayGoalkiArray[$l]['so'] = (string)$match->awayteam['so'];
                                            $awayGoalkiArray[$l]['type'] = 'goalkeeper';
                                            $awayGoalkiArray[$l]['id'] = (string)$awayGolki['id'];
                                            $l++;
                                        }
                                    }
                                }
                                
                            if (!empty($homePlayersArray) && !empty($awayPlayersArray) && !empty($homeGoalKiArray) && !empty($awayGoalkiArray)) {
                                $mergeArray = array_merge($homePlayersArray, $awayPlayersArray, $homeGoalKiArray, $awayGoalkiArray);
                             }
                             
                             if ($mergeArray) {
                                return $mergeArray;
                             }
                          }
                    break;
                }
            }
            
        }
        
        
/**
         * Desc : Filter Array by searchkey and searchvalue
         * @param <String> $searchValue
         * @param <Array> $array
         * @param <String> $searchKey
         * @param <String> $contestType
         * @return <Array> $filtered
         */
        public function filterContestArray($searchValue, $array, $searchKey, $contestType = null) {
        if ($searchValue != "" && $searchKey != "") {
            if ($contestType == "upcomming") {
                $filter = function($array) use($searchValue, $searchKey) {
                            if ($array[$searchKey] == $searchValue) {
                                return $array[$searchKey] == $searchValue;
                            }
                        };
                }
                $filtered = array_filter($array, $filter);
                return $filtered;
            }
        }
        
        /**
         * Desc : Filter Array by searchkey and searchvalue
         * @param <String> $searchValue
         * @param <Array> $array
         * @param <String> $searchKey
         * @param <String> $contestType
         * @return <Array> $filtered
         */
        public function filterContestArrayAllContest($searchValue,$array,$searchKey,$contestType=null){  //echo $searchKey."<br/>"; echo $searchValue;  
          
            if($searchValue != "" && $searchKey != ""){
//                if($contestType == "upcomming"){
                    $filter = function($array) use($searchValue,$searchKey) {                    
                        if($array[$searchKey] == $searchValue){
                            return $array[$searchKey] == $searchValue;
                        }                   
                };  
//                }
                              
                
                $filtered = array_filter($array, $filter);  
                //echo "<pre>"; print_r($filtered); echo "</pre>"; //die;    
                return $filtered;
            }
         

}

    function calculateFppgNFL($playerStat){ //echo "<pre>"; print_r($playerStat); echo "</pre>"; die;
        $points = 0;  $fumble = 0; $loss = 0; $gamesPlay = 1;
//        if($gamesPlay)
        if(isset($playerStat['Passing'])){
            $passBonus = 0;
            if($playerStat['Passing']['yards'] >0){$gamesPlay =  round($playerStat['Passing']['yards'] / $playerStat['Passing']['yards_per_game']); }
            $passYds = $playerStat['Passing']['yards'] * 0.04;
            $passInt = $playerStat['Passing']['interceptions'] * (-1);
            $passTd = $playerStat['Passing']['passing_touchdowns'] * 4;
            if($playerStat['Passing']['yards'] > 300){
                $passBonus = 3;
            }
            $points = $points + $passYds + $passInt + $passTd +$passBonus;
           
        }
        if(isset($playerStat['Rushing'])){
            $rushBonus = 0;
           if($playerStat['Rushing']['yards_per_game'] > 0){ $gamesPlay = round($playerStat['Rushing']['yards'] / $playerStat['Rushing']['yards_per_game']); }
            $rushYds = $playerStat['Rushing']['yards'] * 0.1;
            if($playerStat['Rushing']['yards'] > 100){
                $rushBonus = 3;
            }
            $rushTd = $playerStat['Rushing']['rushing_touchdowns'] * 6;
            $fumbLoss = $playerStat['Rushing']['fumbles_lost'] * (-1);
            $fumble = $fumble + $playerStat['Rushing']['fumbles'];
            $loss = $loss + $playerStat['Rushing']['fumbles_lost'];
            $points = $points + $rushTd + $rushYds + $fumbLoss + $rushBonus;
        }
          if(isset($playerStat['Receiving'])){
            $recBonus = 0;
            if($playerStat['Receiving']['yards_per_game'] > 0){$gamesPlay =   round($playerStat['Receiving']['receiving_yards'] / $playerStat['Receiving']['yards_per_game']);}
            $rec = $playerStat['Receiving']['receptions'] * 1;
            $recYds = $playerStat['Receiving']['receiving_yards'] *0.1;
            $recTd = $playerStat['Receiving']['receiving_touchdowns'] * 6;
            if($playerStat['Receiving']['receiving_yards'] > 100){
                $recBonus = 3;
            }
            $fumbLoss = $playerStat['Receiving']['fumbles_lost'] * (-1);
            $fumble = $fumble + $playerStat['Receiving']['fumbles'];
            $loss = $loss + $playerStat['Receiving']['fumbles_lost'];
            $points = $points + $rec + $recYds + $recTd + $fumbLoss +$recBonus;
        }
        if(isset($playerStat['Kicking'])){
            $extPoints = 0; $yrds39Points = 0; $yrd49Points = 0; $yrd50Points = 0;
            $extPoints = $playerStat['Kicking']['extra_points_made'] * 1;
            if(isset($playerStat['Kicking']['field_goals_from_1_19_yards'])){$yrd1decode = explode("-", $playerStat['Kicking']['field_goals_from_1_19_yards']);}
            if(isset($playerStat['Kicking']['field_goals_from_20_29_yards'])){ $yrd2decode = explode("-", $playerStat['Kicking']['field_goals_from_20_29_yards']);}
            if(isset($playerStat['Kicking']['field_goals_from_30_39_yards'])){$yrd3decode = explode("-", $playerStat['Kicking']['field_goals_from_30_39_yards']);}
            
            if(!empty($yrd1decode) && !empty($yrd2decode) && !empty($yrd3decode)){
                $yrds39Points = ($yrd1decode[0]+$yrd2decode[0]+$yrd3decode[0])*3;
            }
            
            
            if(isset($playerStat['Kicking']['field_goals_from_40_49_yards'])){$yrds49decode = explode("-",$playerStat['Kicking']['field_goals_from_40_49_yards']);
                $yrd49Points = $yrds49decode[0]*4;
            }
            
            if(isset($playerStat['Kicking']['field_goals_from_50_yards'])){$yrd50decode =  explode("-",$playerStat['Kicking']['field_goals_from_50_yards']);
                $yrd50Points = $yrd50decode[0]*5;
            }
            
            $points = $points + $extPoints + $yrds39Points + $yrd49Points + $yrd50Points;
        }
        if(isset($playerStat['Defense'])){// echo "<pre>";print_r($playerStat);echo "</pre>";die;
            $sack = 0; $interceptions=0; $fumRecv = 0; $fumbRetTD=0; $intRetTD=0; $blockRet= 0;
            foreach($playerStat['Defense'] as $dkey=>$dvalue){
                if(isset($dvalue['sacks']))                                 {$sack          = $sack + $dvalue['sacks'];} 
                if(isset($dvalue['interceptions']))                         {$interceptions = $interceptions + $dvalue['interceptions'];}
                if(isset($dvalue['fumbles_recovered']))                     {$fumRecv       = $fumRecv + $dvalue['fumbles_recovered'];}
                if(isset($dvalue['fumbles_returned_for_touchdowns']))       {$fumbRetTD     = $fumbRetTD + $dvalue['fumbles_returned_for_touchdowns'];}
                if(isset($dvalue['interceptions_returned_for_touchdowns'])) {$intRetTD      = $intRetTD + $dvalue['interceptions_returned_for_touchdowns'];}
                if(isset($dvalue['blocked_kicks']))                         {$blockRet      = $blockRet+ $dvalue['blocked_kicks'];}
               
            }
            
            $points = $points + ($sack*1) + ($interceptions * 2) + ($fumRecv * 2) + ($fumbRetTD * 6) + ($intRetTD * 6) + ($blockRet * 2);
        }
        if(isset($playerStat['Returning'])){
            $kkfRetTD=0; $puntRetTD = 0;
            foreach($playerStat['Returning'] as $rkey=>$rvalue){
                if(isset($rvalue['kickoff_return_touchdows']))      {$kkfRetTD  = $kkfRetTD + $rvalue['kickoff_return_touchdows'];}
                if(isset($rvalue['punt_return_touchdowns']))        {$puntRetTD = $puntRetTD + $rvalue['punt_return_touchdowns'];}
              }
            $points = $points + ($kkfRetTD* 6) + ($puntRetTD * 6);
           //echo $gamesPlay; echo "POINTS".$points; die;
        }
        if(isset($gamesPlay) && isset($points)){ 
         if($points >0 && isset($gamesPlay)){$fppg = round($points/$gamesPlay,2);}else{$fppg = 0.0;  }   
         $playerStat['fumble'] = $fumble;
         $playerStat['loss'] = $loss;
         $playerStat['game'] = $gamesPlay;
         $playerStat['fppg'] = $fppg;
        }
       // echo "<pre>"; print_r($playerStat); echo "</pre>";die;
        return $playerStat;
    }
    
    function calculateFppgMLB($playerStat){ 
        if(isset($playerStat['Pitching'])){ //echo "<pre>";print_r($playerStat['Pitching']);echo "</pre>";
            $gamePlay = 1;$pitchPoints = 0;$strkPoints=0;$winPoints=0;$lossPoints=0;$earnedPoints=0;$hitPoints=0;$walkPoints=0;$qPoints=0;$hrPoints=0;$savePoints=0;
            
            if(isset($playerStat['Pitching']['games_played']))  { $gamePlay     = $playerStat['Pitching']['games_played'];   }
            if(isset($playerStat['Pitching']['innings_pitched'])){ $pitchPoints = $playerStat['Pitching']['innings_pitched'] * 2.25 ;   }
            if(isset($playerStat['Pitching']['strikeouts']))    { $strkPoints   = $playerStat['Pitching']['strikeouts'] * 2;   }
            if(isset($playerStat['Pitching']['wins']))          { $winPoints    = $playerStat['Pitching']['wins'] * 4;  }
            if(isset($playerStat['Pitching']['losses']))        { $lossPoints   = $playerStat['Pitching']['losses'] * (-2);  }
            if(isset($playerStat['Pitching']['earned_runs']))   { $earnedPoints = $playerStat['Pitching']['earned_runs'] * (-2); }
            
            if(isset($playerStat['Pitching']['hits']))          { $hitPoints    = $playerStat['Pitching']['hits'] * (-1); }
            if(isset($playerStat['Pitching']['walks']))         { $walkPoints   = $playerStat['Pitching']['walks'] * (-0.6); } 
            if(isset($playerStat['Pitching']['quality_starts'])){ $qPoints      = $playerStat['Pitching']['quality_starts'] * (2.5); } 
            if(isset($playerStat['Pitching']['home_runs']))     { $hrPoints     = $playerStat['Pitching']['home_runs'] * (-3); } 
            if(isset($playerStat['Pitching']['saves']))         { $savePoints   = $playerStat['Pitching']['saves'] * 12; }
            
            $points = $pitchPoints + $strkPoints + $winPoints +$lossPoints + $earnedPoints + $hitPoints +$walkPoints +$qPoints+$hrPoints+$savePoints;
            if(isset($points) && $points!=0){$fppg = round($points / $gamePlay, 2);}else{$fppg=0.0; } 
            $playerStat['fppg'] = $fppg;
        }else if(isset($playerStat['Batting'])){ //echo "<pre>";print_r($playerStat['Batting']);echo "</pre>";
            $gamePlay=1;$hitPoints=0;$doublePoints=0;$tripplePoints=0;$homeRunPoints=0;$battedInPoints=0;$runPoints=0;$walkPoints=0;$stlBasePoints=0;$catStealPoints=0;$strkOutPoint=0;
            if(isset($playerStat['Batting']['games_played']))       { $gamePlay      = $playerStat['Batting']['games_played'];   }
            if(isset($playerStat['Batting']['hits']))               { $hitPoints     = $playerStat['Batting']['hits'] * 3;   }
            if(isset($playerStat['Batting']['doubles']))            { $doublePoints  = $playerStat['Batting']['doubles'] * 5;   }
            if(isset($playerStat['Batting']['triples']))            { $tripplePoints = $playerStat['Batting']['triples'] * 8;   }
            if(isset($playerStat['Batting']['home_runs']))          { $homeRunPoints = $playerStat['Batting']['home_runs'] * 10;   }
            if(isset($playerStat['Batting']['runs_batted_in']))     { $battedInPoints= $playerStat['Batting']['runs_batted_in'] * 2;   }
            if(isset($playerStat['Batting']['runs']))               { $runPoints     = $playerStat['Batting']['runs'] * 2;   }
            if(isset($playerStat['Batting']['walks']))              { $walkPoints    = $playerStat['Batting']['walks'] * 2;   }
            if(isset($playerStat['Batting']['stolen_bases']))       { $stlBasePoints = $playerStat['Batting']['stolen_bases'] * 5;   }
            if(isset($playerStat['Batting']['caught_stealing']))    { $catStealPoints= $playerStat['Batting']['caught_stealing'] * (-2);   }
            if(isset($playerStat['Batting']['strikeouts']))         { $strkOutPoint  = $playerStat['Batting']['strikeouts'] * (-2);   }

            $points = $hitPoints + $doublePoints + $tripplePoints + $homeRunPoints + $battedInPoints + $runPoints +$walkPoints + $stlBasePoints + $catStealPoints +$strkOutPoint;
            if(isset($points) && $points!=0){ $fppg = round($points / $gamePlay, 2); }else{$fppg=0.0; }
            
            $playerStat['fppg'] = $fppg;
        }
        return $playerStat;
    }
    
    function calculateFppgNBA($playerStat){
        $points = 0;$double=array();
        if(isset($playerStat['points_per_game'])){ $points = $points + ($playerStat['points_per_game']); if($playerStat['points_per_game'] > 9){ $double['points_per_game'] = $playerStat['points_per_game'];} }
        if(isset($playerStat['three_point_made_per_game'])){ $points = $points + ($playerStat['three_point_made_per_game'] * 0.5); }
        if(isset($playerStat['rebounds_per_game'])){ $points = $points + ($playerStat['rebounds_per_game'] *  1.25); if($playerStat['rebounds_per_game'] > 9){ $double['rebounds_per_game'] = $playerStat['rebounds_per_game'];} }
        if(isset($playerStat['assists_per_game'])){ $points = $points + ($playerStat['assists_per_game'] * 1.5); if($playerStat['assists_per_game'] > 9){ $double['assists_per_game'] = $playerStat['assists_per_game'];}  }
        if(isset($playerStat['steals_per_game'])){ $points = $points + ($playerStat['steals_per_game'] * 2);  if($playerStat['steals_per_game'] > 9){ $double['steals_per_game'] = $playerStat['steals_per_game'];}  }
        if(isset($playerStat['blocks_per_game'])){ $points = $points + ($playerStat['blocks_per_game'] * 2); if($playerStat['blocks_per_game'] > 9){ $double['blocks_per_game'] = $playerStat['blocks_per_game'];} }
        if(isset($playerStat['turnovers_per_game'])){ $points = $points - ($playerStat['turnovers_per_game'] * 0.5); }
        
        if(isset($playerStat['points'])){ $points = $points + $playerStat['points']; if($playerStat['points'] > 9){ $double['points'] = $playerStat['points'];} }
        if(isset($playerStat['threepoint_goals_made'])){ $points = $points + ($playerStat['threepoint_goals_made'] * 0.5); }
        if(isset($playerStat['total_rebounds'])){ $points = $points + ($playerStat['total_rebounds'] *  1.25); if($playerStat['total_rebounds'] > 9){ $double['total_rebounds'] = $playerStat['blocks_per_game'];} }
        if(isset($playerStat['assists'])){ $points = $points + ($playerStat['assists'] * 1.5); if($playerStat['assists'] > 9){ $double['assists'] = $playerStat['assists'];} }
        if(isset($playerStat['steals'])){ $points = $points + ($playerStat['steals'] * 2); if($playerStat['steals'] > 9){ $double['steals'] = $playerStat['steals'];} }
        if(isset($playerStat['blocks'])){ $points = $points + ($playerStat['blocks'] * 2); if($playerStat['blocks'] > 9){ $double['blocks'] = $playerStat['blocks'];} }
        if(isset($playerStat['turnovers'])){ $points = $points - ($playerStat['turnovers'] * 0.5); }
        if(count($double)>=2){ $points = $points+1.5; }
        if(count($double)>2){ $points = $points+3; }
//        echo "<pre>"; print_r($double); echo "</pre>";
        if(isset($playerStat['field_goals_made']) && isset($playerStat['field_goals_attempts'])){ $playerStat['fg_pct'] = @round($playerStat['field_goals_made']/$playerStat['field_goals_attempts'],2)*100;  }
        if(isset($playerStat['threepoint_goals_made']) && isset($playerStat['threepoint_goals_attempts'])){ $playerStat['three_point_pct'] = @round($playerStat['threepoint_goals_made']/$playerStat['threepoint_goals_attempts'],2)*100;  }
        if(isset($playerStat['freethrows_goals_made']) && isset($playerStat['freethrows_goals_attempts'])){ $playerStat['free_throws_pct'] = @round($playerStat['freethrows_goals_made']/$playerStat['freethrows_goals_attempts'],2)*100;  }
        
        $fppg = 0;
        if($points){
            $fppg = @round($points,2);
        }
        $playerStat['fppg'] = $fppg;
        
        return $playerStat;
    }
    
    function calculateFppgNHL($playerStat){ // in process not completed
        $points = 0; $game = 1;
        if(isset($playerStat['games_played'])){ $game = $playerStat['games_played'];}
        
        if(isset($playerStat['goals'])){ $points = $points + ($playerStat['goals'] * 3); }
        if(isset($playerStat['assists'])){ $points = $points + ($playerStat['assists'] * 2); }
        if(isset($playerStat['shots_on_goal'])){ $points = $points + ($playerStat['shots_on_goal'] * 0.3); }
        if(isset($playerStat['blocked_shots'])){ $points = $points + ($playerStat['blocked_shots'] * 0.5); }
        if(isset($playerStat['penalty_minutes'])){ $points = $points + ($playerStat['penalty_minutes'] * 0.1); }
        if(isset($playerStat['goals']) && $playerStat['goals']!=0 && isset($playerStat['assists']) && $playerStat['assists']!=0){ if($playerStat['assists'] > $playerStat['goals']){ $points = $points + ($playerStat['assists'] * 1); }elseif($playerStat['goals'] > $playerStat['assists']){ $points = $points + ($playerStat['goals'] * 1); }  }
        if(isset($playerStat['shootout_goals'])){ $points = $points + ($playerStat['shootout_goals']*0.2); }
        if(isset($playerStat['goals']) && $playerStat['goals']>=3){ $htrk= intval($playerStat['goals']/3); $points = $points + ($htrk*1.5); }
        //for goalie
        if(isset($playerStat['wins'])){ $points = $points + ($playerStat['wins'] * 3); }
        if(isset($playerStat['saves'])){ $points = $points + ($playerStat['saves'] * 0.2); }
        if(isset($playerStat['total_goals_against'])){ $points = $points + ($playerStat['total_goals_against'] * (-1)); }
        if(isset($playerStat['shutouts'])){ $points = $points + ($playerStat['shutouts'] * 2); }
        
        $fppg = 0;
        if($points){
            $fppg = @round($points/$game,2);
        }
        $playerStat['fppg'] = $fppg;
        
        return $playerStat;
    }
    
    function lineupDetails($sportId){
        switch($sportId){
        case 1 : 
            $lineup = array('QB','RB','RB','WR','WR','WR','TE','FLEX','K','DST');
            break;
        case 2 : 
            $lineup = array('P','P','C','1B','2B','3B','SS','OF','OF','OF');
            break;
        case 3 : 
            $lineup = array('PG','SG','SF','PF','C','G','F','UTIL');
            break;
        case 4 :
            $lineup = array('C','C','W','W','W','D','D','G','UTIL');
             break;
        default :
             break;
        }
        
        return $lineup;
    }

    
       
        
        //sport id 1 for NFL sport
        function arrangeNFLineUp($NFLineup){ 
           // echo "<pre>"; print_r($NFLineup); echo "</pre>"; die;
               $posQB = array();
               $posRB = array();
               $posWR = array();
               $posTE = array();
               $posFLEX = array();
               $posK = array();
               $posDST = array();               
               
               if(empty($posQB)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='QB'){
                                     $posQB[] =  $lineup; 
                               }
                       }
               }
               
               if(empty($posRB)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='RB'){
                                     $posRB[] =  $lineup; 
                               }
                       }
               }
               if(empty($posWR)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='WR'){
                                     $posWR[] =  $lineup; 
                               }
                       }
               }
               if(empty($posTE)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='TE'){
                                     $posTE[] =  $lineup; 
                               }
                       }
               }
               if(empty($posFLEX)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='FLEX'){
                                     $posFLEX[] =  $lineup; 
                               }
                       }
               }
               if(empty($posK)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='K'){
                                     $posK[] =  $lineup; 
                               }
                       }
               }
               if(empty($posDST)){
                       foreach($NFLineup as $lineup){
                               if($lineup['position']=='DST'){
                                     $posDST[] =  $lineup; 
                               }
                       }
               }
               
               
         
               
               return array_merge($posQB,$posRB,$posWR,$posTE,$posFLEX,$posK,$posDST);
              
       }   
       //sport id 2 for MLB sport
        function arrangeMLBLineUp($MLBLineup){
            //echo "<pre>"; print_r($MLBLineup); echo "</pre>"; die;
               $posP = array();
               $posC = array();
               $pos1B = array();
               $pos2B = array();
               $pos3B = array();
               $posSS = array();
               $posOF = array();
               
               if(empty($posP)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='P'){
                                     $posP[] =  $lineup; 
                               }
                       }
               }
               
               if(empty($posC)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='C'){
                                     $posC[] =  $lineup; 
                               }
                       }
               }
               if(empty($pos1B)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='1B'){
                                     $pos1B[] =  $lineup; 
                               }
                       }
               }
               if(empty($pos2B)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='2B'){
                                     $pos2B[] =  $lineup; 
                               }
                       }
               }
               if(empty($pos3B)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='3B'){
                                     $pos3B[] =  $lineup; 
                               }
                       }
               }
               if(empty($posSS)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='SS'){
                                     $posSS[] =  $lineup; 
                               }
                       }
               }
               if(empty($posOF)){
                       foreach($MLBLineup as $lineup){
                               if($lineup['position']=='OF'){
                                     $posOF[] =  $lineup; 
                               }
                       }
               }
               
               
               return array_merge($posP,$posC,$pos1B,$pos2B,$pos3B,$posSS,$posOF);
               
       }
       //sport id 3 for NBA sport
        function arrangeNBALineUp($NBALineup){ 
            //echo "<pre>"; print_r($NBALineup); echo "</pre>"; die;
               $posPG = array();
               $posSG = array();
               $posSF = array();
               $posPF = array();
               $posC = array();
               $posG = array();
               $posF = array();
               $posUTIL = array();
               
               if(empty($posPG)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='PG'){
                                     $posPG[] =  $lineup; 
                               }
                       }
               }
               
               if(empty($posSG)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='SG'){
                                     $posSG[] =  $lineup; 
                               }
                       }
               }
               if(empty($posSF)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='SF'){
                                     $posSF[] =  $lineup; 
                               }
                       }
               }
               if(empty($posPF)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='PF'){
                                     $posPF[] =  $lineup; 
                               }
                       }
               }
               if(empty($posC)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='C'){
                                     $posC[] =  $lineup; 
                               }
                       }
               }
               if(empty($posG)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='G'){
                                     $posG[] =  $lineup; 
                               }
                       }
               }
               if(empty($posF)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='F'){
                                     $posF[] =  $lineup; 
                               }
                       }
               }
               
               if(empty($posUTIL)){
                       foreach($NBALineup as $lineup){
                               if($lineup['position']=='UTIL'){
                                     $posUTIL[] =  $lineup; 
                               }
                       }
               }
               
               
               return array_merge($posPG,$posSG,$posSF,$posPF,$posC,$posG,$posF,$posUTIL);
              
       }
       //sport id 4 for NHL sport
        function arrangeNHLineUp($NHLineup){ 
//            echo "<pre>"; print_r($NHLineup); echo "</pre>"; //die;
               $posC = array();
               $posW = array();
               $posD = array();
               $posG = array();
               $posUTLI = array();                         
               
               if(empty($posC)){
                       foreach($NHLineup as $lineup){
                               if($lineup['position']=='C'){
                                     $posC[] =  $lineup; 
                               }
                       }
               }
               
               if(empty($posW)){
                       foreach($NHLineup as $lineup){
                               if($lineup['position']=='W'){
                                     $posW[] =  $lineup; 
                               }
                       }
               }
               if(empty($posD)){
                       foreach($NHLineup as $lineup){
                               if($lineup['position']=='D'){
                                     $posD[] =  $lineup; 
                               }
                       }
               }
               if(empty($posG)){
                       foreach($NHLineup as $lineup){
                               if($lineup['position']=='G'){
                                     $posG[] =  $lineup; 
                               }
                       }
               }
               if(empty($posUTLI)){
                       foreach($NHLineup as $lineup){
                               if($lineup['position']=='UTIL'){
                                     $posUTLI[] =  $lineup; 
                               }
                       }
               }
          
               return array_merge($posC,$posW,$posD,$posG,$posUTLI);
              
       }  
}
?>