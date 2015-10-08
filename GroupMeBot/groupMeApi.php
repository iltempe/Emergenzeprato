<?php
  class groupMeApi {
    
    // base URL for all API calls
    private $baseUrl     = "https://api.groupme.com/v3";
    
    // token used in all API calls
    private $token  = "";
    
    /**
      *  Curl POST
      *  
      *  $url     (string) URL to POST (endpoint)
      *  $data   (array)   Data payload for the POST call 
      *  
      *  @return   (string)  The result of the curl POST
      *  
    */
    public function apiPost($url,$data=array()) {
      $ch = curl_init($url);
      // if(empty($data['file'])) {
        // $data = json_encode($data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        // 'Content-Type: application/json',
        // 'Content-Length: ' . strlen($data))
        // );
      // }
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
      $c = curl_exec($ch);
	  return $c;
    }
    
    /**
      *  Curl GET
      *  
      *  $url     (string) URL to GET (endpoint)
      *  
      *  @return   (string)  The result of the curl GET
      *  
    */
    public function apiGet($url) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($d))
      );
      $c = curl_exec($ch);
      return $c;
    }
    
    /**
      *  Post a message from a bot to a group
      *  
      *  $strMessage (string) Text of the message to post (limit of 450 characters)
      *                  [$strMessage is optional if $pictureUrl is included]
      *  $groupId    (string) ID of the group to which the message will be posted
      *  $strBotId   (string) ID of the bot which will post the message
      *  $pictureUrl (string) [optional] URL for an image to post with the message as an attachment
      *  
      *  @return           Status 201 (Created)
      *                  No return from this endpoint.
      *
    */
    public function botPost($groupId,$strBotId,$strMessage,$pictureUrl = false) {
      
      // if (empty($pictureUrl) === false){
      // if (stripos($pictureUrl,"i.groupme.com") === false) {
      // Upload image URL to the GroupMe image service and use that URL instead
      // $pictureUrl = $this->uploadImage($pictureUrl);
      // }
      // $arrPayload["attachments"][] = array(
      // "type" => "image",
      // "url" => $pictureUrl
      // );
      //}    
      //$arrPayload["bot_id"]   = $strBotId;
      //$arrPayload["text"]     = $strMessage;
      
      //$postUrl = $this->baseUrl."/bots/post?token={$this->token}";
      //$postUrl = $this->baseUrl."/bots/post";
	  
	  $fields = array(
			'bot_id' => $strBotId,
			'text' => $strMessage
		);
		$response = $this->do_post("https://api.groupme.com/v3/bots/post",$fields);	  
	  //return $this->apiPost($postUrl,$arrPayload);   
	  return $response;
    }
    
public function do_post($url, $data)
{
	$ch = curl_init($url);

  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}
	
    /**
      *  Add user(s) to a group
      *  
      *  $groupId      (string)   ID of the group to which users will be added
      *  $usersToAdd    (array)   Array of user(s) to add using the following string parameters:
      *                    nickname    [required]  The nickname of the user to add
      *                    guid      [optional]  Unique identifier for the user, since /members/add is performed asynchronously.
      *                                    More info on GUIDs here: https://dev.groupme.com/docs/v3#members_add
      *                  And using ONE of the following parameters:                  
      *                    user_id    [required]  The user_id of the user to add
      *                    phone_numer  [required]  The phone number of the user to add
      *                    email      [required]  The email address of the user to add
      *  
      *                  The array must follow this format, where each user is nested inside "members":
      *                  $usersToAdd = array(
      *                    "members"  => array(
      *                      array(
      *                        "nickname"  =>  "_USER_1_NICKNAME_",
      *                        "user_id"  =>  "_USER_ID_1_",
      *                        "guid"    =>  "_GUID_FOR_USER_1_"
      *                      ),
      *                      array(
      *                        "nickname"  =>  "_USER_2_NICKNAME_",
      *                        "user_id"  =>  "_USER_ID_2_",
      *                        "guid"    =>  "_GUID_FOR_USER_2_"
      *                      ),
      *                      array(
      *                        ...
      *                      )
      *                    )
      *                  );  
      *
      *  $boolGetResult  (bool)  [optional] Causes the return of this function to be the results of the add
      *  
      *  @return Returns either:
      *      the result of the /members/add call:
      *        {"meta":
      *          {"code":202},
      *        "response":
      *          {"results_id":"123abc45-67de-f890-1abc-d234efa567bc"}
      *        }
      *
      *      OR returns the results of a call to /members/results using the results_id from /members/add using $this->groupAddUserResults()
      *    
      *  
    */    
    public function groupAddUser($groupId,$userIdsToAdd,$boolGetResult = false) {
      $postUrl = $this->baseUrl."/groups/{$groupId}/members/add?token={$this->token}";
      $r = $this->apiPost($postUrl,$userIdsToAdd);
      $r = json_decode($r,true);
      if ($boolGetResult) {
        return $this->groupAddUserResults($groupId,$r['response']['results_id']);
      }
      return $r;
    }
    
    /**
      *  Brief
      *  
      *  $groupId   (string) ID of the group for which users have been added
      *  $resultsId (string) The results_id from a call to /members/add within the last hour
      *  
      *  @return   Returns an array detailing the results of the /members/add call. 
      *        More info on the return here: https://dev.groupme.com/docs/v3#members_results
      *  
    */
    public function groupAddUserResults($groupId,$resultsId) {
      sleep(1); // necessary to let GroupMe do the adding. The results won't exist yet without it (returns 503)
      $postUrl = $this->baseUrl."/groups/{$groupId}/members/results/".$resultsId."?token={$this->token}";
      return $this->apiGet($postUrl);
    }    
    
    /**
      *  Remove a user from a group
      *  
      *  $groupId  (string)  The group_id for the group from which the user will be removed
      *  $userId  (string)  The user_id for the user to remove
      *  
      *  @return         Status: 200 OK
      *                There is no return from this endpoint.
      *  
    */
    public function groupRemoveUser($groupId,$userId) {
      // Get the user's memberId from their userId
      $memberId = $this->getMemberId($groupId,$userId);
      
      // Remove the user using memberId
      $postUrl = $this->baseUrl."/groups/{$groupId}/members/".$memberId."/remove?token={$this->token}";
      return $this->apiPost($postUrl);
    }
    
    /**
      *  Create a new bot.
      *  
      *  $groupId          (string)  The group_id for the group in which to create the new bot
      *  $strBotName       (string) The name of the new bot
      *  $strCallBackUrl   (string) [optional] URL callback for the bot
      *  $strAvatarUrl     (string) [optional] URL for an avatar image for the bot
      *  
      *  @return        (array)  All info on the newly created bot.
      *                      Example:
      *                      {
      *                        "bot_id": "1234567890",
      *                        "group_id": "1234567890",
      *                        "name": "hal9000",
      *                        "avatar_url": "http://i.groupme.com/123456789",
      *                        "callback_url": "http://example.com/bots/callback"
      *                      }
      *  
    */
    public function botCreate($groupId,$strBotName,$strCallBackUrl = false,$strAvatarUrl = false) {
      if (($strAvatarUrl !== false) && (stripos($strAvatarUrl,"i.groupme.com") === false)) {
        // Upload image URL to the GroupMe image service and use that URL instead
        $strAvatarUrl = $this->uploadImage($strAvatarUrl);
      }
      
      $arrPayload = array(
      "bot"      => array (
      "group_id"    => $groupId,
      "name"      => $strBotName,
      "callback_url"  => $strCallBackUrl,
      "avatar_url"  => $strAvatarUrl,
      )
      );
      $postUrl = $this->baseUrl."/bots?token={$this->token}";
      $r = json_decode($this->apiPost($postUrl,$arrPayload),true);
      return $r['response']['bot']['bot_id'];
    }
    
    /**
      *  Create a new group
      *  
      *  $strGroupName       (string) The name of the group being created
      *  $strGroupDescription   (string)  [optional] A description of the group
      *  $boolShare          (bool)   [optional] Whether to make the group shareable (if TRUE, return will include a link at $r['share_url'])
      *  $strImageUrl        (string) [optional] A URL to an image for the group avatar
      *  
      *  @return           Status 201 (Created)
      *                  Example return array here: https://dev.groupme.com/docs/v3#groups_create
      *  
    */
    public function groupCreate($strGroupName,$strGroupDescription = null, $boolShare = null,$strImageUrl = null) {
      if (!$groupId || $strBotName ) { return false; }
      if ($strImageUrl && (stripos($strImageUrl,"i.groupme.com") === false)) {
        // Upload image URL to the GroupMe image service and use that URL instead
        $strImageUrl = $this->uploadImage($strImageUrl);
      }
      $arrPayload = array(
      "name"      => $strGroupName,
      "description"  => $strGroupDescription,
      "share"      => $boolShare,
      "image_url"    => $strImageUrl,
      );
      $postUrl = $this->baseUrl."/groups?token={$this->token}";
      return json_decode($this->apiPost($postUrl,$arrPayload),true);
    }    
    
    /**
      *  Updates an existing group's information
      *  
      *  $groupId         (string) The group_id for a group
      *  $strGroupName     (string) [optional] The new name for the group
      *  $boolShare        (bool)  [optional] Whether the group should be shareable (defaults to NULL, leaving current setting in place)
      *  $strImageUrl      (string) [optional] The new avatar image for the group
      *  $boolOfficeMode   (bool)  [optional] Whether Office Mode should be enabled (defaults to NULL, leaving current setting in place)
      *  
      *  @return         (array)  Full information about a group, including members and messages.
      *                      Example of return: https://dev.groupme.com/docs/v3#groups_update
      *  
    */
    public function groupUpdate($groupId, $strGroupName = false,$boolShare = null,$strImageUrl = false, $boolOfficeMode = null) {
      if ((empty($strImageUrl) === false) && (stripos($strImageUrl,"i.groupme.com") === false)) {
        // Upload image URL to the GroupMe image service and use that URL instead
        $strImageUrl = $this->uploadImage($strImageUrl);
      }
      if ($strGroupName !== false) {
        $arrPayload['name'] = $strGroupName;
      }    
      if ($boolShare !== null) { // null default because this parameter can be true/false
        $arrPayload['share'] = $boolShare;
      }      
      if ($strImageUrl !== false) {
        $arrPayload['image_url'] = $strImageUrl;
      }
      if ($boolOfficeMode !== null) { // null default because this parameter can be true/false
        $arrPayload['office_mode'] = $boolOfficeMode;
      }
      
      $postUrl = $this->baseUrl."/groups/$groupId/update?token={$this->token}";
      $r = json_decode($this->apiPost($postUrl,$arrPayload),true);
      return $r;
    }
    
    /**
      *  Set Office Mode (on/off) for a particular group.
      *    This makes the same API call as $this->groupUpdate() but only for this particular purpose.
      *  
      *  $groupId          (string)  The group_id for a group
      *  $boolOfficeMode  (bool)     [optional] Whether Office Mode should be enabled (defaults to false, turning OFF Office Mode)
      *  
      *  @return         (array)  Returns the same info on a group as $this->groupUpdate()
      *  
    */
    public function groupSetOfficeMode($groupId,$boolOfficeMode = false) {
      if ($groupId === false) {
        return false;
      }
      
      $arrPayload = array(
      'office_mode' => $boolOfficeMode
      );
      
      $postUrl = $this->baseUrl."/groups/$groupId/update?token={$this->token}";
      $r = json_decode($this->apiPost($postUrl,$arrPayload),true);
      return $r;
    }
    
    
    /**
      *  Get a list of all bots created by the current user (based on $this->token)
      *  
      *  @return  (array)  All info about each bot created by the user.
      *                Example:
      *              [
      *                {
      *                  "bot_id": "1234567890",
      *                  "group_id": "1234567890",
      *                  "name": "hal9000",
      *                  "avatar_url": "http://i.groupme.com/123456789",
      *                  "callback_url": "http://example.com/bots/callback"
      *                },
      *                {
      *                  ...
      *                }
      *              ]
      *  
    */
    public function getBots() {
      $getUrl = $this->baseUrl."/bots?token={$this->token}";
      $r = json_decode($this->apiGet($getUrl),true);
      return $r;
    }
    
    /**
      *  Get details of a particular group.
      *  
      *  $groupId (string) The group_id for a group
      *  
      *  @return   (array)  Information about the group.
      *                Example here: https://dev.groupme.com/docs/v3#groups_show
      *  
    */
    public function getGroup($groupId) {
      $getUrl = $this->baseUrl."/groups/".$groupId."?token={$this->token}";
      $r = json_decode($this->apiGet($getUrl),true);
      return $r;
    }
    
    /**
      *  Get the member_id for a particular user. This is only used in calls to remove a member.
      *  
      *  $groupId    (string) The group_id in which the user belongs
      *  $userId     (string) The user_id of the user
      *  
      *  @return     (string)  The member_id of the user
      *  
    */
    public function getMemberId($groupId,$userId) {
      $arrGroup = $this->getGroup($groupId);
      foreach ($arrGroup['response']['members'] as $k => $v) {
        if ($v['user_id'] == $userId) {
          return $v['id'];
        }
      }
      return false;
    }
    
    /**
      *  Upload an image to the GroupMe Image Service. 
      *    All images sent through GroupMe (attachments & avatars) must be processed through this service first.
      *  
      *  $strImageURL   (string) Full URL of an image to upload to the GroupMe Image Service
      *  
      *  @return       (string)  Full URL of the image hosted on the GroupMe Image Service.
      *                    Format: http://i.groupme.com/768x1024.jpeg.78805a221a988e79ef3f42d7c5bfd418
      *  
    */
    public function uploadImage($strImageURL) {
      // Set a temporary directory to store the image during processing
      $tmpDir = $_SERVER['DOCUMENT_ROOT'] . '/tmp/';
      if (!file_exists($tmpDir)) {
        mkdir($tmpDir, 0777, true);
      }
      $imgSavePath = $tmpDir . md5($strImageURL) . '.png';
      file_put_contents($imgSavePath, file_get_contents($strImageURL));
      
      // Create the API payload
      $arrPayload =   array(
      "access_token" => $this->token,
      "file" => "@$imgSavePath"
      );
      
      $postUrl = "https://image.groupme.com/pictures";
      $r = json_decode($this->apiPost($postUrl,$arrPayload),true);
      
      // Delete (unlink) the temprary copy of the image
      unlink($imgSavePath);
      return $r['payload']['picture_url'];
    }
    
    /**
      *  Force a name change for a user. This is not an official GroupMe API endpoint, but utilizes a hack (remove & re-add) to force a name change.
      *  
      *  $groupId    (string) The group_id in which the user belongs
      *  $userId     (string) The user_id of the user
      *  $strNewName (string) The name to impose on the user
      *  
      *  @return     (array)  Same return information as call to $this->groupAddUser()
      *  
    */
    public function userForceNameChange($groupId,$userId,$strNewName) {
      // Remove the user from the group
      $this->groupRemoveUser($groupId,$userId);
      
      // Add them back to the group with the desired name
      $arrAddToGroup['members'][] = array(
      "nickname"    =>  $strNewName
      ,"user_id"    =>  $userId
      );
      
      return $this->groupAddUser($groupId,$arrAddToGroup);      
    }
  }
?>  