/* ================================================================ 
This copyright notice must be untouched at all times.

The original version of this scriptt and the associated (x)html
is available at http://www.stunicholls.com/menu/hover_drop_1.html
Copyright (c) 2005-2007 Stu Nicholls. All rights reserved.
This script and the associated (x)html may be modified in any 
way to fit your requirements.
=================================================================== */

/* Credits: Stu Nicholls */
/* URL: http://www.stunicholls.com/menu/pro_drop_1/stuHover.js */

stuHover = function() {
	var cssRule;
	var newSelector;
	for (var i = 0; i < document.styleSheets.length; i++)
	{
		
		for (var x = 0; x < document.styleSheets[i].rules.length ; x++)
			{
			cssRule = document.styleSheets[i].rules[x];
			//注意此处LI一定要大写
			if (cssRule.selectorText.indexOf("LI:hover") != -1)
			{
				 newSelector = cssRule.selectorText.replace(/li:hover/gi, "li.iehover");
				document.styleSheets[i].addRule(newSelector , cssRule.style.cssText);
			}
		}
	}
	var getElm = document.getElementById("menu").getElementsByTagName("li");
	//注意此处取得的是menu下面所有的li元素，不管他是不是还处于其他ul之下
	for (var i=0; i<getElm.length; i++) {
	    if((getElm[i].className == "sub")||(getElm[i].className == "fly"))
		{
			getElm[i].onmouseover=function() {
				this.className+=" iehover";
			}
			getElm[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" iehover\\b"), "");
			}
		}
		
	}
}


