<?php

class Notifications {

    public function checkNotifications()
    {
      //  $query = $this->database::select("Select * from notifications where id ='' and viewed='0' LIMIT 5");
        
        foreach($query as $notification)
        {
            //chooses the image for the notification
            switch($notification['image'])
            {
                default: $image = "public_files/includes/global.png";
            }
            post($notification[''],$notification[''],
                    $image);
        }
    }

    public function post($title, $content, $image) {
        $temp = 'n-title';
        $temp1 = 'n-image';
        $imagein = "src='$image'";
        ?> <script type='text/javascript'>
            function noti(){
	 $.sticky('<img id="<?=$temp1; ?>" src="<?=$image; ?>" width="30px" height"30px"><div id="<?=$temp; ?>"><?=$title; ?></div><b><?=$content; ?></b>');
	 };
         noti();</script>
        <?php
    }
    public function postToVar($title, $content, $image){
        $temp = 'n-title';
        $temp1 = 'n-image';
        $imagein = "src='$image'";
        
        $var= " <script type='text/javascript'>function noti(){ $.sticky('<img id=" . $temp1 . " src='$image' width='30px' height'30px'><div id='$temp'>$title</div>$content</b>');
	 };
         noti();</script>";
        return $var;
    }

}
