/**
 *     Left right image slideshow gallery
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
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

function Lrisg_help()
{
	window.open("http://www.gopiplus.com/work/2011/04/25/wordpress-plugin-left-right-image-slideshow-gallery/");
}