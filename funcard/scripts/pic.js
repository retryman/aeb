// JavaScript Document
function change_colour_2(id)
{
		$("#"+id).css("filter", "none");
		$("#"+id).css("-webkit-filter", "grayscale(0%)");
}

function change_gray_2(id)
{
		$("#"+id).css("filter", "gray");
		$("#"+id).css("-webkit-filter", "grayscale(100%)");
}