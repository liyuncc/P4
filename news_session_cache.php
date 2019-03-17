<?php
/**
 * @package ITC281
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 1.1 2011/10/11
 * @link http://www.newmanix.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @todo finish instruction sheet
 * @todo add more complicated checkbox & radio button examples
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
/*
$Feeds[] = new Feed('Huey','Fishing',.15);
$Feeds[] = new Feed('Dewey','Camping',.12);
$Feeds[] = new Feed('Louie','Flying Kites',.11);

foreach($Feeds as $Feed){
    echo '<p>' . $Feed . '</p>';
}
die;
*/


//END CONFIG AREA ----------------------------------------------------------

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display feeds
	 	showFeeds();
    break;
	default: # 1)Ask user to enter their name 
	 	feedForm();
}

function feedForm()
{# shows form so user can enter their name.  Initial scenario
	get_header(); #defaults to header_inc.php	
	
	echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.Name,"Please Enter Feed ID")){return false;}
			if(empty(thisForm.Hobby,"Please Enter Name")){return false;}
			if(empty(thisForm.Allowance,"Please Enter Data")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
	<p align="center">Please enter your name</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
		<table align="center">
        
            <tr>
				<td align="right">ID</td>
				<td>
					<input type="text" name="ID" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            
            <tr>
				<td align="right">Name</td>
				<td>
					<input type="text" name="Name" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>

            <tr>
				<td align="right">Data</td>
				<td>
					<input type="text" name="Data" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            

			<tr>
				<td align="center" colspan="2">
					<input type="submit" value="Please Enter Your Feed Info"><em>(<font color="red"><b>*</b> required field</font>)</em>
				</td>
			</tr>
		</table>

		<input type="hidden" name="act" value="display" />

	</form>
	';
    
	get_footer(); #defaults to footer_inc.php
}

function showFeeds()
{#form submits here we show entered name
	get_header(); #defaults to footer_inc.php
     
    startSession();
    
    //1. create an array if we don't have one
     if(!isset($_SESSION['Feeds'])){
         
       //$_SESSION['Feeds'] = array(); 
       $_SESSION['Feeds'][] = new Feed($_POST['ID'],$_POST['Name'],$_POST['Data']);
       
    }
    //2. if feeds exist, check if the current feed is stored

         //dumpDie($_SESSION['Feeds']);

    //$_SESSION['Feeds'] is the object
    //[] add new feeds to the end of the array
    

    //3. if feed is stored, check the time
    
    
    //4. if time is current, use the cache
    dumpDie($_POST);
    

	/*echo '<h3 align="center">' . smartTitle() . '</h3>';
	echo '<p align="center">Your name is <b>' . $myName . '</b>!</p>';
	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';*/
    
	get_footer(); #defaults to footer_inc.php
}


class Feed{
    public $ID = 0;
    public $Name = '';
    public $Data = '';
    public $Time = '';
    public $TimeStamp = '';
    
    
    public function __construct($ID, $Name, $Data, $Time, $TimeStamp){
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Data = $Data;
        $this->Time = date("Y-m-d H:i:s");
        $this->TimeStamp = time();
    }//end Feed constructor
    

    

}//end Feed class

