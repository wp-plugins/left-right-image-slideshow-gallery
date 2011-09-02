/*
##################################################################################################################################
###### Project   : Left right image slideshow gallery  																		######
###### File Name : setting.js                   																			######
###### Purpose   : This javascript is to authenticate the form.  															######
###### Created   : 26-04-2011                  																				######
###### Modified  : 26-04-2011                  																				######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        											######
###### Link      : #      																									######
##################################################################################################################################
*/


function Lrisg_submit()
{
	if(document.Lrisg_form.Lrisg_path.value=="")
	{
		alert("Please enter the image path.")
		document.Lrisg_form.Lrisg_path.focus();
		return false;
	}
	else if(document.Lrisg_form.Lrisg_link.value=="")
	{
		alert("Please enter the target link.")
		document.Lrisg_form.Lrisg_link.focus();
		return false;
	}
	else if(document.Lrisg_form.Lrisg_target.value=="")
	{
		alert("Please enter the target status.")
		document.Lrisg_form.Lrisg_target.focus();
		return false;
	}
//	else if(document.Lrisg_form.Lrisg_title.value=="")
//	{
//		alert("Please enter the image title.")
//		document.Lrisg_form.Lrisg_title.focus();
//		return false;
//	}
	else if(document.Lrisg_form.Lrisg_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.Lrisg_form.Lrisg_order.focus();
		return false;
	}
	else if(isNaN(document.Lrisg_form.Lrisg_order.value))
	{
		alert("Please enter the display order, only number.")
		document.Lrisg_form.Lrisg_order.focus();
		return false;
	}
	else if(document.Lrisg_form.Lrisg_status.value=="")
	{
		alert("Please select the display status.")
		document.Lrisg_form.Lrisg_status.focus();
		return false;
	}
	else if(document.Lrisg_form.Lrisg_type.value=="")
	{
		alert("Please enter the gallery type.")
		document.Lrisg_form.Lrisg_type.focus();
		return false;
	}
}

function Lrisg_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_Lrisg_display.action="options-general.php?page=left-right-image-slideshow-gallery/image-management.php&AC=DEL&DID="+id;
		document.frm_Lrisg_display.submit();
	}
}	

function Lrisg_redirect()
{
	window.location = "options-general.php?page=left-right-image-slideshow-gallery/image-management.php";
}
