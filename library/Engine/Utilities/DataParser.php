<?php

// all methods are using switch case, to add new sport add the required urls which provides the feeds
// also write the required array format structure to get the formatted data
class Engine_Utilities_DataParser {

    private static $_instance = null;

    //Prevent any oustide instantiation of this class
    private function __construct() {
        $objCore = Engine_Core_Core::getInstance();
        $this->_appsettings = $objCore->getAppSetting();
    }

    private function __clone() {
        
    }

//Prevent any copy of this object

    public static function getInstance() {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Engine_Utilities_DataParser();
        return self::$_instance;
    }

    public function xmlLoad() {
        if (func_num_args() > 0) {
            $url = func_get_arg(0);
            try {
                $client = new Zend_Http_Client($url);
                $response = $client->request();
                $data = simplexml_load_string($response->getBody());
                return $data;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

// provide the sport name, if you want to add new sport feeds, just add another case
// also write the required data parsing array to get the data    
    public function getPlayerList() {
        if (func_num_args() > 0) {
            $gameName = func_get_arg(0);
            switch ($gameName) {
                case 'PGA':
                    $url = "http://api.sportsdatallc.org/golf-t1/profiles/pga/" . date('Y') . "/players/profiles.xml?api_key=" . $this->_appsettings->pgaKey; //hsp8pewy5xd8sbq6gvaexfth";

                    $response = $this->xmlLoad($url);
                    $players = array();
                    if (isset($response->season->player)) {
                        $index = 0;
                        foreach ($response->season->player as $player) {
                            if (isset($player['member'])) {
                                if ($player['member'] == 'false') {
                                    $players[$index]['status'] = 0;
                                } else {
                                    $players[$index]['status'] = 1;
                                }
                            }
                            if (isset($player['id'])) {
                                $players[$index]['id'] = (string) $player['id'];
                            }
                            if (isset($player['first_name'])) {
                                $players[$index]['first_name'] = (string) $player['first_name'];
                            }
                            if (isset($player['last_name'])) {
                                $players[$index]['last_name'] = (string) $player['last_name'];
                            }
                            if (isset($player['height'])) {
                                $players[$index]['height'] = (string) $player['height'];
                            }
                            if (isset($player['weight'])) {
                                $players[$index]['weight'] = (string) $player['weight'];
                            }
                            if (isset($player['birthday'])) {
                                $players[$index]['birthday'] = (string) $player['birthday'];
                            }
                            if (isset($player['country'])) {
                                $players[$index]['country'] = (string) $player['country'];
                            }
                            if (isset($player['residence'])) {
                                $players[$index]['residence'] = (string) $player['residence'];
                            }
                            if (isset($player['birth_place'])) {
                                $players[$index]['birth_place'] = (string) $player['birth_place'];
                            }
                            if (isset($player['updated'])) {
                                $players[$index]['updated'] = (string) $player['updated'];
                            }
                            $players[$index]['position'] = "G";
                            $players[$index]['team_code'] = "";
                            $index++;
                        }
                    }

                    return $players;
                    break;
                default :

                    break;
            }
        }
    }

    //function to get the matches schedule for different sport,
    // add new sport array formatt to get the data
    public function getMatchSchedule() {
        if (func_num_args() > 0) {
            $sport = func_get_arg(0);
            switch ($sport) {
                case "PGA":
                    $url = "http://api.sportradar.us/golf-t1/schedule/pga/" . date('Y') . "/tournaments/schedule.xml?api_key=" . $this->_appsettings->pgaKey; //hsp8pewy5xd8sbq6gvaexfth";

                    $response = $this->xmlLoad($url);

                    $tour = array();
                    $i = 0;
                    if (isset($response) && !empty($response)) {
                        foreach ($response->season->tournament as $tournament) {
                            $tour[$i]['id'] = (string) $tournament['id'];
                            $tour[$i]['name'] = (string) $tournament['name'];
                            $tour[$i]['event_type'] = (string) $tournament['event_type'];
                            $tour[$i]['purse'] = (string) $tournament['purse'];
                            $tour[$i]['winning_share'] = (string) $tournament['winning_share'];
                            $tour[$i]['points'] = (string) $tournament['points'];
                            $tour[$i]['start_date'] = (string) $tournament['start_date'];
                            $tour[$i]['end_date'] = (string) $tournament['end_date'];

                            if (isset($tournament->venue) && !empty($tournament->venue)) {
                                $tour[$i]['venue']['id'] = (string) $tournament->venue['id'];
                                $tour[$i]['venue']['name'] = (string) $tournament->venue['name'];
                                $tour[$i]['venue']['city'] = (string) $tournament->venue['city'];
                                $tour[$i]['venue']['state'] = (string) $tournament->venue['state'];
                                $tour[$i]['venue']['zipcode'] = (string) $tournament->venue['zipcode'];
                                $tour[$i]['venue']['cuntry'] = (string) $tournament->venue['cuntry'];
                            }
                            if (isset($tournament->venue->course) && !empty($tournament->venue->course)) {
                                $tour[$i]['venue']['course']['id'] = (string) $tournament->venue->course['id'];
                                $tour[$i]['venue']['course']['name'] = (string) $tournament->venue->course['name'];
                                $tour[$i]['venue']['course']['yardage'] = (string) $tournament->venue->course['yardage'];
                                $tour[$i]['venue']['course']['par'] = (string) $tournament->venue->course['par'];

                                if (isset($tournament->venue->course->holes) && !empty($tournament->venue->course->holes)) {
                                    $h = 0;
                                    foreach ($tournament->venue->course->holes->hole as $holes) {
                                        $tour[$i]['venue']['course']['holes']['hole'][$h]['number'] = (string) $holes['number'];
                                        $tour[$i]['venue']['course']['holes']['hole'][$h]['par'] = (string) $holes['par'];
                                        $tour[$i]['venue']['course']['holes']['hole'][$h]['yardage'] = (string) $holes['yardage'];
                                        $h++;
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                    return $tour;
                    break;

                default:
                    break;
            }
        }
    }

    //to get the match score for perticular match and sport
    public function getMatchScore($sportId, $matchId) {
        if (func_num_args() > 0) {
//            $sport = func_get_arg(0);
//            $matchId = func_get_arg(1);
//            $matchId = "c8216106-b97a-4768-bd64-d3499e320c92";
            switch ($sportId) {
                case 1 : //PGA sport
                    $url = "http://api.sportradar.us/golf-t1/leaderboard/pga/" . date('Y') . "/tournaments/" . $matchId . "/leaderboard.xml?api_key=" . $this->_appsettings->pgaKey; //hsp8pewy5xd8sbq6gvaexfth";

                    $response = $this->xmlLoad($url);

                    $score = array();
                    if (isset($response) && !empty($response)) {
                        $score['id'] = (string) $response['id'];
                        $score['name'] = (string) $response['name'];
                        $score['purse'] = (string) $response['purse'];
                        $score['winning_share'] = (string) $response['winning_share'];
                        $score['points'] = (string) $response['points'];
                        $score['event_type'] = (string) $response['event_type'];
                        $score['start_date'] = (string) $response['start_date'];
                        $score['end_date'] = (string) $response['end_date'];
                        $score['coverage'] = (string) $response['coverage'];
                        $score['status'] = (string) $response['status'];

                        if (isset($response->playoff->player) && !empty($response->playoff->player)) {
                            $p = 0;
                            foreach ($response->playoff->player as $playoff) {
                                $score['playoff']['player'][$p]['first_name'] = (string) $playoff['first_name'];
                                $score['playoff']['player'][$p]['last_name'] = (string) $playoff['last_name'];
                                $score['playoff']['player'][$p]['country'] = (string) $playoff['country'];
                                $score['playoff']['player'][$p]['id'] = (string) $playoff['id'];
                                $score['playoff']['player'][$p]['position'] = (string) $playoff['position'];
                                $score['playoff']['player'][$p]['score'] = (string) $playoff['score'];
                                $score['playoff']['player'][$p]['strokes'] = (string) $playoff['strokes'];
                                $score['playoff']['player'][$p]['rounds']['round']['score'] = (string) $playoff->rounds->round['score'];
                                $score['playoff']['player'][$p]['rounds']['round']['strokes'] = (string) $playoff->rounds->round['strokes'];
                                $score['playoff']['player'][$p]['rounds']['round']['thru'] = (string) $playoff->rounds->round['thru'];
                                $score['playoff']['player'][$p]['rounds']['round']['eagles'] = (string) $playoff->rounds->round['eagles'];
                                $score['playoff']['player'][$p]['rounds']['round']['birdies'] = (string) $playoff->rounds->round['birdies'];
                                $score['playoff']['player'][$p]['rounds']['round']['pars'] = (string) $playoff->rounds->round['pars'];
                                $score['playoff']['player'][$p]['rounds']['round']['bogeys'] = (string) $playoff->rounds->round['bogeys'];
                                $score['playoff']['player'][$p]['rounds']['round']['double_bogeys'] = (string) $playoff->rounds->round['double_bogeys'];
                                $score['playoff']['player'][$p]['rounds']['round']['other_scores'] = (string) $playoff->rounds->round['other_scores'];
                                $score['playoff']['player'][$p]['rounds']['round']['holes_in_one'] = (string) $playoff->rounds->round['holes_in_one'];
                                $score['playoff']['player'][$p]['rounds']['round']['sequence'] = (string) $playoff->rounds->round['sequence'];
                                $p++;
                            }
                        }


                        if (isset($response->leaderboard->player) && !empty($response->leaderboard->player)) {
                            $l = 0;
                            foreach ($response->leaderboard->player as $leaderboard) { //echo "<pre>"; print_r($leaderboard->rounds->round);die;
                                $score['leaderboard']['player'][$l]['first_name'] = (string) $leaderboard['first_name'];
                                $score['leaderboard']['player'][$l]['last_name'] = (string) $leaderboard['last_name'];
                                $score['leaderboard']['player'][$l]['country'] = (string) $leaderboard['country'];
                                $score['leaderboard']['player'][$l]['id'] = (string) $leaderboard['id'];
                                $score['leaderboard']['player'][$l]['position'] = (string) $leaderboard['position'];
                                $score['leaderboard']['player'][$l]['score'] = (string) $leaderboard['score'];
                                $score['leaderboard']['player'][$l]['strokes'] = (string) $leaderboard['strokes'];

                                if (isset($leaderboard->rounds->round)) {
                                    $r = 0;
                                    foreach ($leaderboard->rounds->round as $round) { //echo "<pre>"; print_r($round);die;
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['score'] = (string) $round['score'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['strokes'] = (string) $round['strokes'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['thru'] = (string) $round['thru'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['eagles'] = (string) $round['eagles'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['birdies'] = (string) $round['birdies'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['pars'] = (string) $round['pars'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['bogeys'] = (string) $round['bogeys'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['double_bogeys'] = (string) $round['double_bogeys'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['other_scores'] = (string) $round['other_scores'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['holes_in_one'] = (string) $round['holes_in_one'];
                                        $score['leaderboard']['player'][$l]['rounds']['round'][$r]['sequence'] = (string) $round['sequence'];
                                        $r++;
                                    }
                                }
                                $l++;
                            }
                        }
                    }

                    return $score;
                    break;
                default:
                    break;
            }
        }
    }

    //to get the players stats from the urls for perticular sport
    public function playerStats() {
        if (func_num_args() > 0) {
            $sport = func_get_arg(0);

            switch ($sport) {
                case "PGA":
                    $url = "http://api.sportradar.us/golf-t1/seasontd/pga/2015/players/statistics.xml?api_key=" . $this->_appsettings->pgaKey; //hsp8pewy5xd8sbq6gvaexfth";
                    $response = $this->xmlLoad($url);

                    $playerStats = array();
                    if (isset($response->season->player) && !empty($response->season->player)) {
                        $p = 0;
                        foreach ($response->season->player as $player) {
                            $playerStats[$p]['id'] = (string) $player['id'];
                            $playerStats[$p]['first_name'] = (string) $player['first_name'];
                            $playerStats[$p]['last_name'] = (string) $player['last_name'];
                            $playerStats[$p]['country'] = (string) $player['country'];
                            $playerStats[$p]['statistics']['events_played'] = (string) $player->statistics['events_played'];
                            $playerStats[$p]['statistics']['first_place'] = (string) $player->statistics['first_place'];
                            $playerStats[$p]['statistics']['second_place'] = (string) $player->statistics['second_place'];
                            $playerStats[$p]['statistics']['third_place'] = (string) $player->statistics['third_place'];
                            $playerStats[$p]['statistics']['top_10'] = (string) $player->statistics['top_10'];
                            $playerStats[$p]['statistics']['top_25'] = (string) $player->statistics['top_25'];
                            $playerStats[$p]['statistics']['cuts'] = (string) $player->statistics['cuts'];
                            $playerStats[$p]['statistics']['cuts_made'] = (string) $player->statistics['cuts_made'];
                            $playerStats[$p]['statistics']['withdrawals'] = (string) $player->statistics['withdrawals'];
                            $playerStats[$p]['statistics']['points'] = (string) $player->statistics['points'];
                            $playerStats[$p]['statistics']['points_rank'] = (string) $player->statistics['points_rank'];
                            $playerStats[$p]['statistics']['earnings'] = (string) $player->statistics['earnings'];
                            $playerStats[$p]['statistics']['earnings_rank'] = (string) $player->statistics['earnings_rank'];
                            $playerStats[$p]['statistics']['drive_avg'] = (string) $player->statistics['drive_avg'];
                            $playerStats[$p]['statistics']['drive_acc'] = (string) $player->statistics['drive_acc'];
                            $playerStats[$p]['statistics']['gir_pct'] = (string) $player->statistics['gir_pct'];
                            $playerStats[$p]['statistics']['world_rank'] = (string) $player->statistics['world_rank'];
                            $playerStats[$p]['statistics']['strokes_gained'] = (string) $player->statistics['strokes_gained'];
                            $playerStats[$p]['statistics']['hole_proximity_avg'] = (string) $player->statistics['hole_proximity_avg'];
                            $playerStats[$p]['statistics']['scrambling_pct'] = (string) $player->statistics['scrambling_pct'];
                            $playerStats[$p]['statistics']['scoring_avg'] = (string) $player->statistics['scoring_avg'];
                            $p++;
                        }
                    }
                    return $playerStats;
                    break;
                default:
                    break;
            }
        }
    }

    public function pgaTourHoleStats($tournamentId) {
        $url = 'http://api.sportradar.us/golf-t1/hole_stats/pga/' . date('Y') . '/tournaments/' . $tournamentId . '/hole-statistics.xml?api_key=' . $this->_appsettings->pgaKey; //hsp8pewy5xd8sbq6gvaexfth';

        $response = $this->xmlLoad($url);
        $holeStats = array();
        if (isset($response) && !empty($response)) {
            $holeStats['id'] = $response['id'];
            $holeStats['name'] = $response['name'];
            $holeStats['purse'] = $response['purse'];
            $holeStats['winning_share'] = $response['winning_share'];
            $holeStats['points'] = $response['points'];
            $holeStats['event_type'] = $response['event_type'];
            $holeStats['start_date'] = $response['start_date'];
            $holeStats['end_date'] = $response['end_date'];
            $holeStats['coverage'] = $response['coverage'];
            $holeStats['status'] = $response['status'];
            $holeStats['id'] = $response['id'];
            $holeStats['id'] = $response['id'];
        }

//         echo "<pre>"; print_r($response); die;
    }

    // get the player list for the perticular sport and for perticular match
    public function getMatchPlayerList($sportId, $matchId) {
        $matchPlayers = array();
        switch ($sportId) {
            case 1 : // response url for PGA sport, we will get the list of player depending on perticular match id
                $url = "http://api.sportradar.us/golf-t1/summary/pga/" . date('Y') . "/tournaments/" . $matchId . "/summary.xml?api_key=" . $this->_appsettings->pgaKey;
                $response = $this->xmlLoad($url);
                if (isset($response) && !empty($response)) {
                    if (isset($response->field->player)) { $i=0;
                        foreach ($response->field->player as $player) { 
                            $matchPlayers[$i]['first_name'] = (string) $player['first_name'];
                            $matchPlayers[$i]['last_name'] = (string) $player['last_name'];
                            $matchPlayers[$i]['country'] = (string) $player['country'];
                            $matchPlayers[$i]['id'] = (string) $player['id'];
                            $i++;
                        }
                    }
                }
                break;
            case 2 : // add other case for different sports
                break;
            default :
                break;
        }
        return $matchPlayers;
    }

}

?>