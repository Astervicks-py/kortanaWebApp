<?php
session_start();
require_once "./classes.php";
require_once "./config.php";
$DB = new DB();
$user_id = $_SESSION['id'];
$output = "";
$user_data = new User();

$sql = "SELECT * FROM groups";
$groups = $DB->read($sql);
$membered_group = [];
// if(count($groups) > 0)
// {
// 	foreach ($groups as $group) {
// 		$members = json_decode($group['members'],true);
// 		if(in_array($user_id,$members))
// 		{
// 			$membered_group[] = $group['group_id'];
// 		}
// 	}

   	
// }

// if(count($membered_group) > 0)
// {
//     foreach ($membered_group as $group_id) {
//         $sql = "SELECT * FROM groups WHERE group_id = '$group_id'";
//         $row = $DB->read($sql)[0];
//         if($row['group_dp'] == "" || $row['group_dp'] == NULL)
//         {
//             $group_dp = '<img style="width:100%" src="./noprofile.jpeg">';
//         }else{
//             $group_dp = '<img style="width:100%" src="./includes/'.$row['group_dp'].'">';
//         }

//         $message = "";
//         $sql = "SELECT * FROM group_chat WHERE incoming_id = '$group_id' ORDER BY serial_no DESC LIMIT 1";
//         $result2 = mysqli_query($conn,$sql);
//         $read = 0;
//         if(mysqli_num_rows($result2) > 0){
//             $row2 = mysqli_fetch_assoc($result2);
//             $people_that_read = json_decode($row2['read'], true);
//             if($people_that_read != NULL)
//             {
//                 if(!in_array($user_id, $people_that_read))
//                 {
//                     $text_color = "#0f0";
//                 }else{
//                     $text_color = "#fff";
//                 }
//             }else{
//                 $text_color = "#0f0";
//             }
//             // echo("<pre>");
//             // print_r($people_that_read);
//             // echo("</pre>");
            

//             if($row2['outgoing_id'] == $user_id)
//             {
//                 $prefix = '<div style="color:#f00">You: </div>';
//             }else{
//                 $sql = "SELECT username FROM users WHERE user_id = '$row2[outgoing_id]'";
//                 $sender_username = $DB->read($sql)[0]['username'];
//                 $prefix = '<div style="color:#f00">'.$sender_username.': </div>';;
//             }
//             if(strlen($row2['message']) > 20){
//                 $message = $prefix . ' ' .substr($row2['message'],0,20).'...';
//             }else{
//                 $message = $prefix . ' ' .$row2['message'];
//             }
//         }else{
//             $message = 'No message available';
//         }

//         $sql = "SELECT `read` FROM group_chat WHERE incoming_id = '$group_id' ORDER BY serial_no DESC";
//         $read_members = $DB->read($sql);
//     // print_r( $read_members);
//     // die();
//         $number_of_unread_messages = 0;
//         foreach ($read_members as $chat) { 
//             $have_read = json_decode($chat['read'],true); 
//             if($have_read != NULL){
//                 if(!in_array($user_id,$have_read))
//                 {   
//                     $number_of_unread_messages = $number_of_unread_messages + 1;
//                 }
//             }
//         }

//         if($number_of_unread_messages == 0)
//         {
//             $no_message = "";
//         }else{
//             $no_message = '<span style="width:30px;color:#fff;
//             height:30px;display:flex;
//             background:#f00;justify-content:center;
//             font-size:.9rem;align-items:center;
//             position:absolute;border-radius:50%; 
//             top:0;right:0;transform:translate(20%, -20%);">'.$number_of_unread_messages.'</span>';

//         }
       

        
//         $output .= 
//         '   <a href="./group-chat_page.php?id='.$row['group_id'].'" class="user_link" style="position:relative">
//                 <div class="user">
//                     <div class="profile-pic" style="display:flex;justify-content: center;align-items:center;">
//                         '.$group_dp.'
//                     </div>
                    
//                     <div class="details" style="position:relative;display:flex;flex-direction:column">
//                         <h5 class="user-name">'.$row['group_name'].'</h5>
//                         <div style="font-size:.8rem;color:'.$text_color.'">'.$message.'</div>
//                     </div>
                    
//                 </div>
//                 '.$no_message.'
//             </a>
//         ';
//     }
// }else{
//     $output = "You are not a member of any group";
// }


// echo $output;



/**
 * Another approach
 */
$output = '';
$history;
$user_row = $user_data->user_data($user_id);
if($user_row)
{
    $group_history = $user_row[0]['group_history'];
    if(!is_null($group_history))
    {
        $history = json_decode($group_history);
        if(is_array($history))
        {
            foreach ($history as $group_id) {
                $sql = "SELECT * FROM group_chat WHERE incoming_id = '$group_id' ORDER BY serial_no DESC LIMIT 1";
                if($result = $DB->read($sql))
                {
                    $chat_detail = $result[0];
                    // print_r( $result);
                    $sql = "SELECT * FROM groups WHERE group_id = '$chat_detail[incoming_id]'";
                    if($result = $DB->read($sql))
                    {
                        $row = $result[0];

                        if($row['group_dp'] == "" || $row['group_dp'] == NULL)
                        {
                            $group_dp = '<img style="width:100%" src="./noprofile.jpeg">';
                        }else{
                            $group_dp = '<img style="width:100%" src="./includes/'.$row['group_dp'].'">';
                        }

                        /** Checking if User read */
                        $people_that_read = json_decode($chat_detail['read'], true);
                        if($people_that_read != NULL)
                        {
                            if(!in_array($user_id, $people_that_read))
                            {
                                $text_color = "#0f0";
                            }else{
                                $text_color = "#fff";
                            }
                        }else{
                            $text_color = "#0f0";
                        }

                        $message = '';
                        if($chat_detail['outgoing_id'] == $user_id)
                        {
                            $prefix = '<span style="color:#f00">You: </span>';
                        }else{
                            $sender = $user_data->user_data($chat_detail['outgoing_id']);
                            $sender_username = $sender[0]['username'];
                            $prefix = '<span style="color:#f00">'.$sender_username.': </span>';;
                        }
                        if(strlen($chat_detail['message']) > 20){
                            $message = $prefix . ' ' .substr($chat_detail['message'],0,20).'...';
                        }else{
                            $message = $prefix . ' ' .$chat_detail['message'];
                        }


                        /** getting nukmber of unread messages */
                        $sql = "SELECT `read` FROM group_chat WHERE incoming_id = '$group_id' ORDER BY serial_no DESC";
                        $read_members = $DB->read($sql);
                        $number_of_unread_messages = 0;
                        foreach ($read_members as $chat) { 
                            $have_read = json_decode($chat['read'],true); 
                            if($have_read != NULL){
                                if(!in_array($user_id,$have_read))
                                {   
                                    $number_of_unread_messages = $number_of_unread_messages + 1;
                                }
                            }
                        }

                        if($number_of_unread_messages == 0)
                        {
                            $no_message = "";
                        }else{
                            $no_message = '<span style="width:30px;color:#fff;
                            height:30px;display:flex;
                            background:#f00;justify-content:center;
                            font-size:.9rem;align-items:center;
                            position:absolute;border-radius:50%; 
                            top:0;right:0;transform:translate(20%, -20%);">'.$number_of_unread_messages.'</span>';

                        }


                        $output .= 
                        '   <a href="./group-chat_page.php?id='.$row['group_id'].'" class="user_link" style="position:relative">
                                <div class="user">
                                    <div class="profile-pic" style="display:flex;justify-content: center;align-items:center;">
                                        '.$group_dp.'
                                    </div>
                                    
                                    <div class="details" style="position:relative;display:flex;flex-direction:column">
                                        <h5 class="user-name">'.$row['group_name'].'</h5>
                                        <div style="font-size:.8rem;color:'.$text_color.'">'.$message.'</div>
                                    </div>
                                    
                                </div>
                                '.$no_message.'
                            </a>
                        ';

                                        
                    }
                }
            }
        }
    }

    $sql = "SELECT * FROM groups";
    $groups = $DB->read($sql);
    $membered_group = [];
    if(count($groups) > 0)
    {
        foreach ($groups as $group) {
            $members = json_decode($group['members'],true);
            if(in_array($user_id,$members))
            {
                $membered_group[] = $group['group_id'];
            }
        }
    }

    foreach ($membered_group as $group_id) {
        if(is_array($history))
        {
            if(!in_array($group_id,$history))
            {
                $sql = "SELECT * FROM groups WHERE group_id = '$group_id'";
                if($result = $DB->read($sql))
                {   
                    $row = $result[0];
                    $message = "No message available";
                    if($row['group_dp'] == "" || $row['group_dp'] == NULL)
                    {
                        $group_dp = '<img style="width:100%" src="./noprofile.jpeg">';
                    }else{
                        $group_dp = '<img style="width:100%" src="./includes/'.$row['group_dp'].'">';
                    }


                    $output .= 
                    '   <a href="./group-chat_page.php?id='.$row['group_id'].'" class="user_link" style="position:relative">
                            <div class="user">
                                <div class="profile-pic" style="display:flex;justify-content: center;align-items:center;">
                                    '.$group_dp.'
                                </div>
                                
                                <div class="details" style="position:relative;display:flex;flex-direction:column">
                                    <h5 class="user-name">'.$row['group_name'].'</h5>
                                    <div style="font-size:.8rem;color:#fff">'.$message.'</div>
                                </div>
                                
                            </div>
                        </a>
                    ';
                }
            }
        }
        
    }
}

echo $output;