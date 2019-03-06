<?php
/**
 * index.php along with subject_view.php provides a news aggregator app
 * @package nmPager
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 3.02 2011/05/18
 * @link http://www.newmanix.com/
 * @license https://www.apache.org/licenses/LICENSE-2.0
 * @see demo_view_pager.php
 * @see Pager.php 
 * @todo none
 */


# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 


get_header(); #defaults to theme header or header_inc.php

# connection comes first in mysqli (improved) function
# SQL statement
$sql =  "SELECT * FROM wn19_Feeds";

$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "news/index.php");
}




/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

?>

<h3 align="center">Catogies</h3>

<?php



#reference images for pager
//$prev = '<img src="' . $config->virtual_path . '/images/arrow_prev.gif" border="0" />';
//$next = '<img src="' . $config->virtual_path . '/images/arrow_next.gif" border="0" />';

#images in this case are from font awesome
$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset


$showTotalNumber = 0;
if(mysqli_num_rows($result) > 0)
{
     
    #records exist - process
 #1 is singular, 0 are plurals
	
    if($myPager->showTotal()==1){$itemz = "category";}else{$itemz = "categories";}  //deal with plural
    
    //echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
	
    
    echo '
        
        <table class="table table-hover">
            <thead>
            <tr>
              <th scope="col">Category</th>
            </tr>
            </thead>
            <tbody>
        ';
    
    
    while($row = mysqli_fetch_assoc($result))
	{# process each row, <a> tag is a key, create a link to the view page
      
        $idd = $_GET['id'];
        if($idd == $row['SubjectID']){
           echo '
           <tr>
              <td><a href="' . VIRTUAL_PATH . 'news/subject_view.php?id=' . (int)$row['FeedID'] . '">' . dbOut($row['Feed']) . '</a></td>
           </tr>
    
        '; 
            $showTotalNumber ++;
        }
        
        
         //echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['Title']) . '</a></div>';
        
	}
    
    echo '<div align="center">We have ' . $showTotalNumber . ' ' . $itemz . '!</div>';
    echo '
        </tbody>
        </table>

    ';
    
    
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
    
}else{#no records
    
    echo "<div align=center>There are currently no surveys.</div>";	
    
}

@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
