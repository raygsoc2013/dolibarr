<?php
/* Copyright (C) 2007-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *   	\file       dev/Cronjobss/Cronjobs_page.php
 *		\ingroup    mymodule othermodule1 othermodule2
 *		\brief      This file is an example of a php page
 *					Initialy built by build_class_from_table on 2013-03-17 18:50
 */

//if (! defined('NOREQUIREUSER'))  define('NOREQUIREUSER','1');
//if (! defined('NOREQUIREDB'))    define('NOREQUIREDB','1');
//if (! defined('NOREQUIRESOC'))   define('NOREQUIRESOC','1');
//if (! defined('NOREQUIRETRAN'))  define('NOREQUIRETRAN','1');
//if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK','1');
//if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL','1');
//if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU','1');	// If there is no menu to show
//if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML','1');	// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX','1');
//if (! defined("NOLOGIN"))        define("NOLOGIN",'1');		// If this page is public (can be called outside logged session)

// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include '../main.inc.php';
if (! $res && file_exists("../../main.inc.php")) $res=@include '../../main.inc.php';
if (! $res && file_exists("../../../main.inc.php")) $res=@include '../../../main.inc.php';
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../dolibarr/htdocs/main.inc.php';     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res && file_exists("../../../../../dolibarr/htdocs/main.inc.php")) $res=@include '../../../../../dolibarr/htdocs/main.inc.php';   // Used on dev env only
if (! $res) die("Include of main fails");
// Change this following line to use the correct relative path from htdocs
dol_include_once('/module/class/cronjob.class.php');

// Load traductions files requiredby by page
$langs->load("companies");
$langs->load("other");
$langs->load("cron");

// Get parameters
$id			= GETPOST('id','int');
$action		= GETPOST('action','alpha');
$myparam	= GETPOST('myparam','alpha');
$action='list';

// Protection if external user
if ($user->societe_id > 0) accessforbidden();
if (! $user->admin) accessforbidden();


/*******************************************************************
* ACTIONS
*
* Put here all code to do according to value of "action" parameter
********************************************************************/

if ($action == 'add')
{
	$object=new Cronjobs($db);
	$object->prop1=$_POST["field1"];
	$object->prop2=$_POST["field2"];
	$result=$object->create($user);
	if ($result > 0)
	{
		// Creation OK
	}
	{
		// Creation KO
		$mesg=$object->error;
	}
}





/***************************************************
* VIEW
*
* Put here all code to build page
****************************************************/

llxHeader('','MyPageName','');

$form=new Form($db);


//print '<table border="0" width="100%" class="notopnoleftnoright">';
//print '<tr><td valign="top" width="30%" class="notopnoleft">';
print '<div class="fichecenter"><div class="fichethirdleft">';





//print '</td><td valign="top" width="70%" class="notopnoleftnoright">';
print '</div><div class="fichetwothirdright"><div class="ficheaddleft">';



// Example 1 : Adding jquery code
print '<script type="text/javascript" language="javascript">
jQuery(document).ready(function() {
	function init_myfunc()
	{
		jQuery("#myid").removeAttr(\'disabled\');
		jQuery("#myid").attr(\'disabled\',\'disabled\');
	}
	init_myfunc();
	jQuery("#mybutton").click(function() {
		init_needroot();
	});
});
</script>';


// Example 2 : Adding links to objects
// The class must extends CommonObject class to have this method available
//$somethingshown=$object->showLinkedObjectBlock();


// Example 3 : List of data
if ($action == 'list')
{
    $sql = "SELECT";
    $sql.= " t.rowid,";

		$sql.= " t.tms,";
		$sql.= " t.datec,";
		$sql.= " t.command,";
		$sql.= " t.params,";
		$sql.= " t.datelastrun,";
		$sql.= " t.lastresult,";
		$sql.= " t.lastoutput,";
		$sql.= " t.fk_user,";
		$sql.= " t.note";


    $sql.= " FROM ".MAIN_DB_PREFIX."cronjob as t";
    //$sql.= " WHERE field3 = 'xxx'";
    //$sql.= " ORDER BY field1 ASC";


    print_fiche_titre($langs->trans("ListOfCronJobs"),'','').'<br>';


    print '<table class="noborder">'."\n";
    print '<tr class="liste_titre">';
    print_liste_field_titre($langs->trans('Id'),$_SERVER['PHP_SELF'],'t.rowid','',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('Command'),$_SERVER['PHP_SELF'],'t.command','',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('DateCreation'),$_SERVER['PHP_SELF'],'t.datec','align="center"',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('LastOutput'),$_SERVER['PHP_SELF'],'','',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('DateLastRun'),$_SERVER['PHP_SELF'],'t.datelastrun','align="center"',$param,'',$sortfield,$sortorder);
    print_liste_field_titre($langs->trans('LastResult'),$_SERVER['PHP_SELF'],'t.lastresult','align="right"',$param,'',$sortfield,$sortorder);
    print '</tr>';

    dol_syslog($script_file." sql=".$sql, LOG_DEBUG);
    $resql=$db->query($sql);
    if ($resql)
    {
        $num = $db->num_rows($resql);
        $i = 0;
        if ($num)
        {
            while ($i < $num)
            {
                $obj = $db->fetch_object($resql);
                if ($obj)
                {
                    // You can use here results
                    print '<tr><td>';
                    print $obj->rowid;
                    print '</td><td>';
                    print $obj->command;
                    print '</td><td align="center">';
                    print $db->jdate($obj->datec);
                    print '</td><td>';
                    print '';
                    print '</td><td align="center">';
                    print $db->jdate($obj->datelastrun);
                    print '</td><td align="right">';
                    print $obj->lastresult;
                    print '</td></tr>';
                }
                $i++;
            }
        }
    }
    else
    {
        $error++;
        dol_print_error($db);
    }

    print '</table>'."\n";
}


//print '</td></tr></table>';
print '<div></div></div>';


// End of page
llxFooter();
$db->close();
?>
