<?php
 // $Id$
 // note: reports modules
 // lic : GPL

$page_name = basename($GLOBALS["REQUEST_URI"]);
include_once ("lib/freemed.php");
include_once ("lib/API.php");
include_once ("lib/module.php");
include_once ("lib/module_reports.php");

//----- Login/authenticate
freemed_open_db ();

//----- Set page title
$page_title = (_("Reports"));

//----- Add page to history
page_push();

//----- Create user object
if (!is_object($this_user)) $this_user = new User;

 // Check for appropriate access level
if (freemed_get_userlevel ($LoginCookie) < $database_level) { 
   $display_buffer .= "
      <P>
        "._("You don't have access for this menu.")."
      <P>
    ";
	template_display();
} // end if not appropriate userlevel

// information for module loader
$category = "Reports";
$module_template = "
	<TR>
	<TD ALIGN=RIGHT>#icon#</TD>
	<TD ALIGN=LEFT><A HREF=\"module_loader.php?module=#class#\"".
	">#name#</A></TD>
	</TR>
";

// module loader
$module_list = new module_list (PACKAGENAME,".report.module.php");
if (!$module_list->empty_category($category)) {
	$display_buffer .= "
	<P>
	<CENTER>
	<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 VALIGN=MIDDLE
	 ALIGN=CENTER>
	".$module_list->generate_list($category, 0, $module_template)."
    </TABLE>
	</CENTER>
	<P>
	<CENTER>
		<A HREF=\"main.php\"
		>"._("Return to Main Menu")."</A>
	</CENTER>
	<P>
	";
} else {
	$display_buffer .= "
	<P>
	<CENTER>
		"._("There are no report modules present.")."
	</CENTER>
	<P>
	<CENTER>
		<A HREF=\"main.php\"
		>"._("Return to Main Menu")."</A>
	</CENTER>
	<P>
	";
}

freemed_close_db ();
template_display();
?>
