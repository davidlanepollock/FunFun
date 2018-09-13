<?php

class Ads {

    public function createAd($AdName, $Type, $Detail, $Target) {
        //Todo: input add into database tables
        //  Generate a prerendered version for faster fetching
    }

    //used by websites to fetch the highest bidder for a specific ad location
    private static function fetchAd($SiteInfo) {
        //*web auth and site id -> send back a unique key -> website replys with same unique key
        //grab partner websites id and auth code
        if ($this->PartnerValid()) {

            // check db for highest bid for specific location
            // assign highest bidding ad thatt meets requirements to website for page load
            $AdId = $this->highestBidder($SiteInfo);
            // increment the ad impressions by 1, while keeping tally of demographics
            $this->updateValues($AdId, $SiteInfo['SiteId']);
            //return ad
            return $this->generateAd($AdId);
        } else {
            //invalid partner
        }
    }

    private static function updateValues($AdId, $SiteId) {
        //update database with +1 impression for ad
        //if tracking allowed, update tracking statistics as well
    }

    private static function generateAd($AdId) {
        if ($AdId !== 0) {
            return $this->CacheChecker($AdId);
        } else {
            //cannot find ad
        }
    }

    //used by websites to navigate to the proper location once an ad is clicked
    public static function viewAd() {
        $AdId = getUrl();
        $url = grabAdUrl();
        //update click values
        head('location:' . $url);
    }

    private static function CacheChecker($AdId) {
        //check the cache for ad
        if (AdCacheCheck($AdId)) {
            return AdCache($AdId);
        }
        //if ad doesnt cache doesnt exist, check if ad exists then create cache
        else {
            //check if ad exists
            if ($this->AdCheck($AdId)) {
                return AdCache($AdId);
            }
        }
    }

    //checks if ad exists then creates a cached version
    // returns true or false
    private static function AdCheck($AdId) {
        // check db for ad id
        //create cache from ad info
        //
        if (AdCacheCheck($AdId)) {
            
        }
        // return ad true or false
    }

    private static function highestBidder($SiteInfo) {
        if ($this->TrackingEnabled()) {
            $id = $SiteInfo['id'];
            $AuthCode = $SiteInfo['auth'];
        } else {
            $id = $SiteInfo['id'];
            $AuthCode = $SiteInfo['auth'];
            $OSType;
            $Location;
        }

        $db = new Database();
        //select ad id from user that meet the ad requirements
        $db->query("");

        //verify website is a valid partner
        //check db for qualifying ads based on demographic info
    }

    //checks tracking cookie to see if user enabled tracking (allows compliance with
    // eu laws
    private static function TrackingEnabled() {
        $TrackingEnabled = filter_input(INPUT_COOKIE, "MSDTracking", FILTER_SANITIZE_STRING);
        switch ($TrackingEnabled) {
            case "True":
                return true;
            default :
                return false;
        }
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    public static function pageLoad($id, $auth) {

        //get website id and auth
        $SiteInfo['SiteId'] = $id;
        $SiteInfo['AuthCode'] = $auth;
        $PublicIP = get_client_ip();
        $access_key = NULL;
        $ch = curl_init('https://api.ipstack.com/' . $PublicIP . '?access_key=' . $access_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($json, true);
        $SiteInfo['country'] = $json['country_name'];
        $SiteInfo['region'] = $json['region_name'];
        $SiteInfo['city'] = $json['city'];
        $SiteInfo['zip'] = $json['zip'];
        $SiteInfo['lat'] = $json['latitude'];
        $SiteInfo['long'] = $json['longitude'];
        return $this->fetchAd($SiteInfo);
    }

    public static function grabID() {
        //have to sanitize input
        $ad = new Ads;
        $siteID = filter_input(INPUT_POST, "siteID", FILTER_SANITIZE_NUMBER_INT);
        $accessKey = filter_input(INPUT_POST, "accessKey", FILTER_SANITIZE_STRING);
        $ip = $ad->get_client_ip();
        $result = null;
        $result->id = 1112;
        $result->siteID = $siteID;
        $result->accessKey = $accessKey;
        $result->uIP = $ip;
        echo json_encode($result);
        return false;
    }

    public static function grabCampaign() {
        //have to sanitize input
        $ad = new Ads;
        $result = null;
        $result->id = 1112;
        $sortType = filter_input(INPUT_POST, "sortType", FILTER_SANITIZE_NUMBER_INT);
        $result->campaigns = $ad->grabCampaigns($sortType);
        if ($result->campaigns->rowCount() === 0) {
            $result->id = 1111;
            $result->campaigns = null;
            $result->rowCount = 0;
        } else {
            $result->rowCount = $result->campaigns->rowCount();
            $result->campaigns = $result->campaigns->fetchAll();
        }
        echo json_encode($result);
        return false;
    }

    private function grabCampaigns($sortType) {

        switch ($sortType) {
            default: null;
        }
        $user = Sessions::get('uid');
        $db = new Database();
        //select ad id from user that meet the ad requirements
        $query = $db->select("SELECT * FROM ADCampaign WHERE uid='$user'");

        return $query;
    }

    public static function setCookie() {
        $name = filter_input(INPUT_POST, "Name", FILTER_SANITIZE_STRING);
        $value = filter_input(INPUT_POST, "Value", FILTER_SANITIZE_NUMBER_INT);
        $time = filter_input(INPUT_POST, "Time", FILTER_SANITIZE_STRING);
        setcookie($name, $value);
        $cookie = null;
        $cookie->set = filter_input(INPUT_COOKIE, $name, FILTER_VALIDATE_INT);
        echo json_encode($cookie);
    }

    public static function updateCampaignView() {
        $ad = new Ads;
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        $user = Sessions::get('uid');
        $result = null;
        $result->id = 1112;
        if (isset($user)) {
            $result->campaigns = $ad->grabCampaignView($user, $id);
            if ($result->campaigns->rowCount() === 0) {
                $result->id = 1111;
                $result->campaigns = null;
                $result->rowCount = 0;
            } else {
                $result->rowCount = $result->campaigns->rowCount();
                $result->campaigns = $result->campaigns->fetchAll();
            }
        }
        echo json_encode($result);
    }

    private function grabCampaignView($user, $id) {
        $db = new Database();
        //select ad id from user that meet the ad requirements
        $query = $db->select("SELECT * FROM ADCampaign WHERE uid='$user' AND id='$id' LIMIT 1");
        return $query;
    }
    public static function updateCampaign()
    {
        $ad = new Ads;
        $noti = new Notifications;
        
        $result = null;
        $result->id = 1112;
        $result->noti = $noti->postToVar("Changes Saved.", "We have successfully updated your campaign changes.", "public_files/includes/global.png");
        
        echo json_encode($result);
        return false;
    }
    public function main() {
        
    }

}

?>