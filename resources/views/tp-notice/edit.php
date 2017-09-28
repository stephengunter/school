<link rel=stylesheet type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel=stylesheet type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .pad-top {
        padding-top: 10px;
    }
    .modal-header-danger {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #d9534f;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
</style>


<style>
    .hummingbird-treeview,
    .hummingbird-treeview * {
        list-style: none;
        font-size: 20px;
        line-height: 24px;
    }

        .hummingbird-treeview label {
            font-weight: normal;
        }


        .hummingbird-treeview input[type=checkbox] {
            width: 16px;
            height: 16px;
            padding: 0px;
            margin: 0px;
        }

        .hummingbird-treeview ul:not(.hummingbird-base) {
            display: none;
        }

        .hummingbird-treeview .fa {
            font-style: normal;
            cursor: pointer;
        }
</style>



<style>
    .checkbox label:after,
    .radio label:after {
        content: '';
        display: table;
        clear: both;
    }

    .checkbox .cr,
    .radio .cr {
        position: relative;
        display: inline-block;
        border: 1px solid #a9a9a9;
        border-radius: .25em;
        width: 1.3em;
        height: 1.3em;
        float: left;
        margin-right: .5em;
    }

    .radio .cr {
        border-radius: 50%;
    }

        .checkbox .cr .cr-icon,
        .radio .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .radio .cr .cr-icon {
            margin-left: 0.04em;
        }

    .checkbox label input[type="checkbox"],
    .radio label input[type="radio"] {
        display: none;
    }

        .checkbox label input[type="checkbox"] + .cr > .cr-icon,
        .radio label input[type="radio"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
        .radio label input[type="radio"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled + .cr,
        .radio label input[type="radio"]:disabled + .cr {
            opacity: .5;
        }
</style>
<div class="container">
    
    <h1>發送校務系統通知</h1>
    <form enctype="multipart/form-data" id="form-notice" method="POST"  action="http://school/tp-notices">
        <div class="row">
            <div class="col-md-12">
                <label>通知內容</label>
                <textarea name="Content" class="form-control" rows="6" cols="50"></textarea>
                <small id="err-Content" class="text-danger" style="display: none;">請輸入通知內容</small>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>附加檔案</label>
                <input id="attachment-file" name="Attachment" type="file">
            </div>
            <div class="col-md-8 mb-3">
                <label>檔案顯示名稱</label>
                <input type="text" name="Attachment_Title" class="form-control" >
                <small id="err-filename" class="text-danger" style="display: none;">請輸入檔案顯示名稱</small>
            </div>
        </div>
        <div class="row" style="padding-top:10px">

            <div class="col-md-4">
                <label>通知對象身份</label>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="Staff" id="chk-staff" value="0">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        職員 <span id="level-text"></span>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="Teacher" value="0">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        教師
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="Student" value="0">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                        學生
                    </label>
                </div>

                <small id="err-roles" class="text-danger" style="display: none;">請選擇通知對象身份</small>

            </div>
            <div class="col-md-8">
                <div id="unit-list" style="display:none">
                    <label>通知對象部門</label>
                    <button id="btn-edit-units" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-pencil"></span> 編輯
                    </button>
                    <textarea id="unit-names" class="form-control" rows="5" cols="50" disabled></textarea>
                    <input type="text" id="unit-codes" name="Units" value="" />
                    <small id="err-units" class="text-danger" style="display: none;">請選擇通知對象部門</small>
                </div>
                <div id="class-list"  class="pad-top" style="display:none">
                    <label>通知對象班級</label>
                    <button id="btn-edit-classes" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-pencil"></span> 編輯
                    </button>
                    <textarea id="class-names"  class="form-control" rows="5" cols="50" disabled></textarea>
                    <input type="text" id="class-codes" name="Classes" value="" />
                    <small id="err-classes" class="text-danger" style="display: none;">請選擇通知對象班級</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>備註</label>
                <textarea name="PS" class="form-control" rows="3" cols="50"></textarea>
            </div>

        </div>
        <div class="row" style="padding-top:10px">
            <div class="col-md-12">
                <button class="btn btn-success" type="submit">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    存檔
                </button>
            </div>

        </div>

       

       

        <input type="text" name="Levels"  value="" />
      

    </form>

    <input id="select-type" type="hidden" value="" />



</div>


<button id="open-custom-modal" type="button" style="display:none" data-toggle="modal" data-target="#custom-modal">Open Modal</button>
<div class="modal fade" id="custom-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button id="close-custom-modal" type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="custom-modal-title"></h4>
            </div>
            <div class="modal-body" id="custom-modal-content">
                <div class="row" style="padding-bottom:10px">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <button id="tree-select-all" class="btn btn-primary btn-sm">全選</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button id="tree-cancel-all" class="btn btn-default btn-sm">全取消</button>
                        </div>
                    </div>
                    <div class="col-md-6" id="div-level">
                        <div class="form-inline">
                            <div class="checkbox">
                                <label>
                                    <input id="level-one" class="chk-levels" type="checkbox"  value="1">
                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                    一級主管
                                </label>
                            </div>
                            <div style="padding-left:15px" class="checkbox">
                                <label>
                                    <input id="level-two" class="chk-levels" type="checkbox" value="2">
                                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                    二級主管
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <ul id="treeview-members"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-select-done" class="btn btn-success">確定</button>
               
            </div>
        </div>
    </div>
</div>


<button id="btn-alert-modal" type="button" data-toggle="modal" data-target="#alert-modal">ALERT</button>
<div class="modal fade" id="alert-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div  class="modal-header modal-header-danger">
                <button id="close-button" type="button" class="close" data-dismiss="modal">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                <h3><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> </h3>
            </div>
            <div class="modal-body" id="alert-content">
               
            </div>
            <div class="modal-footer" id="alert-footer">
                <button type="button" id="btn-confirm-ok" class="btn btn-success">確定</button>

                &nbsp; &nbsp;
                <button type="button" id="btn-confirm-cancel" class="btn btn-default">取消</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<script type="text/javascript">
  (function($){

    //global variables

    //this is needed to temporarily disable doubles, e.g. for uncheckAll
    var uncheckAll_doubles = false;

    $.fn.hummingbird = function(options){


	var methodName = options;
	var args = arguments;
	var options = $.extend( {}, $.fn.hummingbird.defaults, options);
	//initialisation
	if (typeof(methodName) == "undefined" ) {
	    return this.each(function(){
		//-------------------options-------------------------------------------------------//
		//change symbols
		if (options.collapsedSymbol != "fa-plus") {
		    $(this).find("i").removeClass("fa-plus").addClass(options.collapsedSymbol);
		}

		//hide checkboxes
		if (options.checkboxes == "disabled") {
		    $(this).find("input:checkbox").hide();
		}

		//collapseAll
		if (options.collapseAll === false) {
		    $.fn.hummingbird.expandAll($(this),options.collapsedSymbol,options.expandedSymbol);
		}
		//-------------------options-------------------------------------------------------//


		//initialise doubles logic
		var doubleMode = false;
		var allVariables = new Object;
		if (options.checkDoubles) {
		    $(this).find('input:checkbox.hummingbirdNoParent').each(function() {
			if (allVariables[$(this).attr("data-id")]) {
			    allVariables[$(this).attr("data-id")].push($(this).attr("id"));
			    //console.log($(this))
			} else {
			    allVariables[$(this).attr("data-id")] = [$(this).attr("id")];
			}
		    });
		    //console.log(JSON.stringify(allVariables));
		}

		//three state logic
		$.fn.hummingbird.ThreeStateLogic($(this),doubleMode,allVariables,options.checkDoubles,options.checkDisabled);

		//expandSingle
		$(this).on("click", 'li i.' + options.collapsedSymbol, function() {
		    $.fn.hummingbird.expandSingle($(this),options.collapsedSymbol,options.expandedSymbol);
		});
		//collapseSingle
		$(this).on("click", 'li i.' + options.expandedSymbol, function() {
		    $.fn.hummingbird.collapseSingle($(this),options.collapsedSymbol,options.expandedSymbol);
		});
	    });
	}

	//checkAll
	if (methodName == "checkAll") {
	    return this.each(function(){
		$.fn.hummingbird.checkAll($(this));
	    });
	}

	//ucheckAll
	if (methodName == "uncheckAll") {
	    return this.each(function(){
		$.fn.hummingbird.uncheckAll($(this));
	    });
	}

	//disableNode
	if (methodName == "disableNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var state = args[1].state;
		$.fn.hummingbird.disableNode($(this),attr,name,state);
	    });
	}

	//enableNode
	if (methodName == "enableNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var state = args[1].state;
		$.fn.hummingbird.enableNode($(this),attr,name,state);
	    });
	}

	//checkNode
	if (methodName == "checkNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var expandParents = args[1].expandParents;
		$.fn.hummingbird.checkNode($(this),attr,name);
		if (expandParents == true) {
		    $.fn.hummingbird.expandNode($(this),attr,name,expandParents,options.collapsedSymbol,options.expandedSymbol);
		}
	    });
	}

	//uncheckNode
	if (methodName == "uncheckNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var collapseChildren = args[1].collapseChildren;
		$.fn.hummingbird.uncheckNode($(this),attr,name);
		if (collapseChildren == true) {
		    $.fn.hummingbird.collapseNode($(this),attr,name,collapseChildren,options.collapsedSymbol,options.expandedSymbol);
		}
	    });
	}



	//setNodeColor
	if (methodName == "setNodeColor") {
	    return this.each(function(){
		var attr = args[1];
		var ID = args[2];
		var color = args[3];
		$.fn.hummingbird.setNodeColor($(this),attr,ID,color);
	    });
	}


	//collapseAll
	if (methodName == "collapseAll") {
	    return this.each(function(){
		$.fn.hummingbird.collapseAll($(this),options.collapsedSymbol,options.expandedSymbol);
	    });
	}

	//expandAll
	if (methodName == "expandAll") {
	    return this.each(function(){
		$.fn.hummingbird.expandAll($(this),options.collapsedSymbol,options.expandedSymbol);
	    });
	}

	//expandNode
	if (methodName == "expandNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var expandParents = args[1].expandParents;
		$.fn.hummingbird.expandNode($(this),attr,name,expandParents,options.collapsedSymbol,options.expandedSymbol);
	    });
	}

	//collapseNode
	if (methodName == "collapseNode") {
	    return this.each(function(){
		var name = args[1].name;
		var attr = args[1].attr;
		var collapseChildren = args[1].collapseChildren;
		$.fn.hummingbird.collapseNode($(this),attr,name,collapseChildren,options.collapsedSymbol,options.expandedSymbol);
	    });
	}

	//getChecked
	if (methodName == "getChecked") {
	    return this.each(function(){
	    var attr = args[1].attr;
		var list = args[1].list;
		var OnlyFinalInstance = args[1].OnlyFinalInstance;
		$.fn.hummingbird.getChecked($(this),attr,list,OnlyFinalInstance);
	    });
	}

	//getUnchecked
	if (methodName == "getUnchecked") {
	    return this.each(function(){
		var attr = args[1].attr;
		var list = args[1].list;
		var OnlyFinalInstance = args[1].OnlyFinalInstance;
		$.fn.hummingbird.getUnchecked($(this),attr,list,OnlyFinalInstance);
	    });
	}

	//search
	if (methodName == "search") {
	    return this.each(function(){
		var treeview_container = args[1].treeview_container;
		var search_input = args[1].search_input;
		var search_output = args[1].search_output;
		var search_button = args[1].search_button;
		if (typeof args[1].dialog !== 'undefined') {
		    var dialog = args[1].dialog;
		} else {
		    var dialog = "";
		}
		if (typeof args[1].enter_key_1 !== 'undefined') {
		    var enter_key_1 = args[1].enter_key_1;
		} else {
		    var enter_key_1 = true;
		}
		if (typeof args[1].enter_key_2 !== 'undefined') {
		    var enter_key_2 = args[1].enter_key_2;
		} else {
		    var enter_key_2 = true;
		}
		if (typeof args[1].scrollOffset !== 'undefined') {
		    var scrollOffset = args[1].scrollOffset;
		} else {
		    var scrollOffset = false;
		}
		if (typeof args[1].OnlyFinalInstance !== 'undefined') {
		    var OnlyFinalInstance = args[1].OnlyFinalInstance;
		} else {
		    var OnlyFinalInstance = false;
		}
		if (typeof args[1].EnterKey !== 'undefined') {
		    var EnterKey = args[1].EnterKey;
		} else {
		    var EnterKey = true;
		}
		$.fn.hummingbird.search($(this),treeview_container,search_input,search_output,search_button,dialog,enter_key_1,enter_key_2,options.collapsedSymbol,options.expandedSymbol,scrollOffset,OnlyFinalInstance,EnterKey);
	    });
	}
    };


    //options defaults
    $.fn.hummingbird.defaults = {
	expandedSymbol: "fa-minus",
	collapsedSymbol: "fa-plus",
	collapseAll: true,
	checkboxes: "enabled",
	checkDoubles: false,
	checkDisabled: false,
    };

    //global vars
    var nodeDisabled = true;


    //-------------------methods--------------------------------------------------------------------------//

    //-------------------checkAll---------------//
    $.fn.hummingbird.checkAll = function(tree){
	tree.children("li").children("label").children("input:checkbox").prop('indeterminate', false).prop('checked', false).trigger("click");
    };

    //-------------------uncheckAll---------------//
    $.fn.hummingbird.uncheckAll = function(tree){
	//console.log(tree.children("li").children("label").children("input:checkbox"))
	//disable checking for doubles temporarily
	uncheckAll_doubles = true;
	tree.children("li").children("label").children("input:checkbox").prop('indeterminate', false).prop('checked', true).trigger("click");
	uncheckAll_doubles = false;
	//console.log(tree.children("li").children("label").children("input:checkbox"));
    };

    //-------------------collapseAll---------------//
    $.fn.hummingbird.collapseAll = function(tree,collapsedSymbol,expandedSymbol){
	tree.find("ul").hide();
	tree.find('.' + expandedSymbol).removeClass(expandedSymbol).addClass(collapsedSymbol);
    };

    //------------------expandAll------------------//
    $.fn.hummingbird.expandAll = function(tree,collapsedSymbol,expandedSymbol){
	tree.find("ul").show();
	tree.find('.' + collapsedSymbol).removeClass(collapsedSymbol).addClass(expandedSymbol);
    };

    //-------------------collapseSingle---------------//
    $.fn.hummingbird.collapseSingle = function(node,collapsedSymbol,expandedSymbol){
	node.parent("li").children("ul").hide();
	node.removeClass(expandedSymbol).addClass(collapsedSymbol);
    };

    //-------------------expandSingle---------------//
    $.fn.hummingbird.expandSingle = function(node,collapsedSymbol,expandedSymbol){
	node.parent("li").children("ul").show();
	node.removeClass(collapsedSymbol).addClass(expandedSymbol);
    };

    //-------------------expandNode---------------//
    $.fn.hummingbird.expandNode = function(tree,attr,name,expandParents,collapsedSymbol,expandedSymbol){
	var that_node = tree.find('input[' + attr + '=' + name + ']');
	var that_ul = that_node.parent("label").siblings("ul");
	that_ul.show().siblings("i").removeClass(collapsedSymbol).addClass(expandedSymbol);
	//expand all parents and change symbol
	if (expandParents === true) {
	    that_node.parents("ul").show().siblings("i").removeClass(collapsedSymbol).addClass(expandedSymbol);
	}
    };

    //-------------------collapseNode---------------//
    $.fn.hummingbird.collapseNode = function(tree,attr,name,collapseChildren,collapsedSymbol,expandedSymbol){
	var that_node = tree.find('input[' + attr + '=' + name + ']');
	var that_ul = that_node.parent("label").siblings("ul");
	//collapse children and change symbol
	if (collapseChildren === true) {
	    that_node.parent("label").parent("li").find("ul").hide().siblings("i").removeClass(expandedSymbol).addClass(collapsedSymbol);
	} else {
	    that_ul.hide().siblings("i").removeClass(expandedSymbol).addClass(collapsedSymbol);
	}
    };

    //-------------------checkNode---------------//
    $.fn.hummingbird.checkNode = function(tree,attr,name){
	tree.find('input:checkbox:not(:checked)[' + attr + '=' + name + ']').prop("indeterminate",false).trigger("click");
    };

    //-------------------uncheckNode---------------//
    $.fn.hummingbird.uncheckNode = function(tree,attr,name){
	tree.find('input:checkbox:checked[' + attr + '=' + name + ']').prop("indeterminate",false).trigger("click");
    };

    //-------------------disableNode---------------//
    $.fn.hummingbird.disableNode = function(tree,attr,name,state){
	var this_checkbox = tree.find('input:checkbox:not(:disabled)[' + attr + '=' + name + ']');
	//for a disabled unchecked node, set node checked and then trigger a click to uncheck
	//for a disabled checked node, set node unchecked and then trigger a click to check
	this_checkbox.prop("checked",state === false);
	nodeDisabled = true;
	this_checkbox.trigger("click");
	//disable this node and all children
	this_checkbox.parent("label").parent("li").find('input:checkbox').prop("disabled",true).parent("label").parent("li").css({'color':'#c8c8c8'});
    };

    //-------------------enableNode---------------//
    $.fn.hummingbird.enableNode = function(tree,attr,name,state){
	var this_checkbox = tree.find('input:checkbox:disabled[' + attr + '=' + name + ']');
	//for a disabled unchecked node, set node checked and then trigger a click to uncheck
	//for a disabled checked node, set node unchecked and then trigger a click to check
	this_checkbox.prop("disabled",false).parent("label").parent("li").css({'color':'#636b6f'});
	//all parents enabled
	this_checkbox.parent("label").parent("li").parents("li").children("label").children("input[type='checkbox']").prop("disabled",false).parents("label").parent("li").css({'color':'#636b6f'});
	//all children enabled
	this_checkbox.parent("label").parent("li").find('input:checkbox').prop("disabled",false).parent("label").parent("li").css({'color':'#636b6f'});
	this_checkbox.prop("checked",state === false);
	nodeDisabled = false;
	this_checkbox.trigger("click");
    };

    //--------------get all checked items------------------//
    $.fn.hummingbird.getChecked = function(tree,attr,list,OnlyFinalInstance){
	if (OnlyFinalInstance == true) {
	    tree.find('input:checkbox.hummingbirdNoParent:checked').each(function () {

		if (attr == "text") {
		    list.push($(this).parent("label").parent("li").text());
		} else {
		    list.push($(this).attr(attr));
		}
	    });
	} else {
	    tree.find('input:checkbox:checked').each(function() {
		if (attr == "text") {
		    list.push($(this).parent("label").parent("li").text());
		} else {
		    list.push($(this).attr(attr));
		}
	    });
	}
    };
    //--------------get all checked items------------------//

    //--------------get all unchecked items------------------//
    $.fn.hummingbird.getUnchecked = function(tree,attr,list,OnlyFinalInstance){
	if (OnlyFinalInstance == true) {
	    tree.find('input:checkbox.hummingbirdNoParent:not(:checked)').each(function() {
		list.push($(this).attr(attr));
	    });
	} else {
	    tree.find('input:checkbox:not(:checked)').each(function() {
		list.push($(this).attr(attr));
	    });
	}
    };
    //--------------get all unchecked items------------------//


    //-------------------setNodeColor---------------//
    $.fn.hummingbird.setNodeColor = function(tree,attr,ID,color){
	tree.find('input:checkbox[' + attr + '=' + ID + ']').parent("li").css({'color':color});
    };

    //--------------three-state-logic----------------------//
    $.fn.hummingbird.ThreeStateLogic = function(tree,doubleMode,allVariables,checkDoubles,checkDisabled) {
	tree.find('input:checkbox').on('click', function(e) {
	    //check / uncheck all checkboxes below that node, if they are not disabled
	    var nodes_below = $(this).parent("label").parent("li").find("input:checkbox:not(:disabled)");
	    var ids = [];
	    nodes_below.each(function(){
		ids.push($(this).attr("id"));
	    });
	    if ($(this).prop("checked")) {
	    	var state = true;
	    	var checkSiblings = "input:checkbox:not(:checked)";
		//fire event
		tree.trigger("nodeChecked",ids.join());
	    } else {
	    	var state = false;
	    	var checkSiblings = "input:checkbox:checked";
		//fire event
		tree.trigger("nodeUnchecked",ids.join());
	    }
	    //check / uncheck all checkboxes below that node
	    nodes_below.prop("indeterminate",false).prop("checked",state);
	    //set all parents indeterminate and unchecked
	    $(this).parent("label").parent().parents("li").children("label").children("input[type='checkbox']").prop("indeterminate",true);
	    $(this).parent("label").parent().parents("li").children("label").children("input[type='checkbox']").prop("checked",false);
	    //travel up the DOM
	    //test if siblings are all checked / unchecked / indeterminate
	    //check / uncheck parents if all siblings are checked /unchecked
	    //thus, set parents checked / unchecked, if children are all checked or all unchecked with no indeterminates
	    $(this).parent("label").parents("li").map(function() {
	    	var indeterminate_sum = 0;
	    	var checked_unchecked_sum = $(this).siblings().addBack().children("label").children(checkSiblings).length;
		if (checkDisabled) {
		    var not_disabled_sum = $(this).siblings().addBack().children("label").children("input:checkbox:not(:disabled)").length;
		}
	    	$(this).siblings().addBack().children("label").children("input:checkbox").map(function() {
	    	    indeterminate_sum = indeterminate_sum + $(this).prop("indeterminate");
	    	});
	    	if ((indeterminate_sum + checked_unchecked_sum) == 0) {
	    	    $(this).parent().parent().children("label").children("input[type='checkbox']").prop("indeterminate",false);
	    	    $(this).parent().parent().children("label").children("input[type='checkbox']").prop("checked",state);
	    	}

		//disabling the node is done after it has been triggered, thus if a node has been disabled
		//i.e. nodeDisabled == true then the not_disabled_sum is actually smaller by one
		if (checkDisabled) {
		    if (nodeDisabled == true) {
			not_disabled_sum--;
			//the next parent group is again normal thus not_disabled_sum must not be incremented by one
			nodeDisabled = false;
		    }
		    if (not_disabled_sum == 0) {
			$(this).parent().parent().children("label").children("input[type='checkbox']").prop("disabled",true).parent("label").parent("li").css({'color':'#c8c8c8'});
		    }
		}
	    });


	    //------------------check if this variable has doubles-----------------------//
	    //------------------and click doubles if needed------------------------------//
	    //------------------only if this is not a double check-----------------------//
	    if (checkDoubles == true && uncheckAll_doubles == false) {
		if (doubleMode == false) {
	    	    //do this for all checked / unchecked checkboxes below that node
	    	    $(this).parent("label").parent("li").find("input.hummingbirdNoParent[type='checkbox']").each(function() {
	    		//check if this node has doubles
	    		var L = allVariables[$(this).attr("data-id")].length;
	    		if ( L > 1) {
	    		    doubleMode = true;
	    		    //if state of these checkboxes is not similar to state
	    		    //-> trigger click
	    		    var Zvar = allVariables[$(this).attr("data-id")];
	    		    for (var i=0;i<L;i++) {
	    			if ($("#" + Zvar[i] ).prop("checked") != state) {
	    			    $("#" + Zvar[i] ).trigger("click");
	    			}
	    		    }
	    		}
	    	    });
	    	    doubleMode = false;
		}
	    }
	    //------------------check if this variable has doubles------------------------//



	    //--------------------------disabled-----------------------------------------//
	    //check if this box has hummingbirdNoParent children
	    if (checkDisabled) {
		if ($(this).hasClass("hummingbirdNoParent") === false) {
		    //if this box has been checked, check if "not checked disabled" exist
		    if (state === true) {
			var disabledCheckboxes = $(this).parent("label").parent("li").find("input:checkbox:not(:checked):disabled");
			var num_state_inverse_Checkboxes = $(this).parent("label").parent("li").find("input:checkbox:checked");
		    }
		    //if this box has been unchecked, check if "checked disabled" exist
		    if (state === false) {
			var disabledCheckboxes = $(this).parent("label").parent("li").find("input:checkbox:checked:disabled");
			var num_state_inverse_Checkboxes = $(this).parent("label").parent("li").find("input:checkbox:not(:checked)");
		    }
		    //if this box has been checked and unchecked disabled exist
		    //set this and all parents indeterminate and checked false. Setting checked false is important to make this box ready for a check
		    //not if all checked or unchecked
		    if (disabledCheckboxes.length > 0 && num_state_inverse_Checkboxes.length > 0) {
			//only if the boxes are enabled
			disabledCheckboxes.parent("label").parent("li").parents("li").children("label").children("input:checkbox:not(:disabled)").prop("indeterminate",true).prop("checked",state);
		    }
		}
	    }
	    //--------------------------disabled-----------------------------------------//

	    //fire event
	    tree.trigger("CheckUncheckDone");
	});
    }
    //--------------three-state-logic----------------------//


    //----------------------------search--------------------------------------//
    $.fn.hummingbird.search = function(tree,treeview_container,search_input,search_output,search_button,dialog,enter_key_1,enter_key_2,collapsedSymbol,expandedSymbol,scrollOffset,OnlyFinalInstance,EnterKey) {

	//trigger search on enter key
	if (EnterKey == true) {
	    $(document).keyup(function(e) {
		if (e.which == 13) {
		    //console.log("current_page= " + enter_key_2)
		    if (enter_key_1 == enter_key_2) {
			$(dialog + " #" + search_button).trigger("click");
		    }
		}
	    });
	}
	var first_search = true;
	var this_var_checkbox = {};
	//hide dropdown search list
	$(dialog + " #" + search_input).on("click", function(e) {
	    $(dialog + " #" + search_output).hide();
	});

	$(dialog + " #" + search_button).on("click", function(e) {
	    //show dropdown search list
	    $(dialog + " #" + search_output).show();
	    var search_str = $(dialog + " #" + search_input).val().trim();
	    //empty dropdown
	    $(dialog + " #" + search_output).empty();
	    //loop through treeview
	    var num_search_results = 0;
	    if (OnlyFinalInstance == true) {
		var OnlyFinalInstance_Class = ".hummingbirdNoParent";
	    } else {
		var OnlyFinalInstance_Class = "";
	    }
	    tree.find('input:checkbox' + OnlyFinalInstance_Class).each(function() {
		if ($(this).parent().text().toUpperCase().includes(search_str.toUpperCase())) {
		    //add items to dropdown
		    $(dialog + " #" + search_output).append('<li id="drop_' + $(this).attr("id")  + '"><a href="#">' + $(this).parent().text() + '</a></li>');
		    num_search_results++;
		}
	    });
	    if (num_search_results == 0) {
		$(dialog + " #" + search_output).append("&nbsp; &nbsp; Nothing found");
	    }
	    //click on search dropdown
	    $(dialog + " #" + search_output + " li").on("click", function(e) {
		//no focus on the input field to trigger the search scrolling
		e.preventDefault();
	    	//hide dropdown
	    	$(dialog + " #" + search_output).hide();
	    	//set value of input field
	    	$(dialog + " #" + search_input).val($(this).text());
	    	//reset color of last selection
	    	if (first_search == false) {
		    if (this_var_checkbox.prop("disabled")) {
			this_var_checkbox.parent("label").parent("li").css({'color':'#c8c8c8'});
		    } else {
			this_var_checkbox.parent("label").parent("li").css({'color':'#636b6f'});
		    }
	    	}
	    	//before jumping to the hummingbirdNoParent a collapse all is needed
	    	tree.hummingbird("collapseAll");
	    	//get this checkbox
	    	this_var_checkbox = tree.find('input[id="' + $(this).attr("id").substring(5) + '"]');
		//parent uls
	    	var prev_uls = this_var_checkbox.parents("ul");
		//change plus to minus
	    	prev_uls.closest("li").children("i").removeClass(collapsedSymbol).addClass(expandedSymbol);
		//highlight hummingbirdNoParent
	    	this_var_checkbox.parent("label").parent("li").css({'color':'#f0ad4e'});
	    	first_search = false;
	    	//expand parent uls
		prev_uls.show();
		//---------------------------scrolling-----------------------------------//
		//set scroll position to zero
		if (treeview_container == "body") {
		    //Chrome
		    document.body.scrollTop = 0;
		    //Firefox
		    document.documentElement.scrollTop = 0;
		} else {
		    $(dialog + " #" + treeview_container)[0].scrollTop = 0;
		}
		//get position and offset of element
		var this_var_checkbox_position = this_var_checkbox.position().top;
		this_var_checkbox_position = this_var_checkbox_position+scrollOffset;

		if (treeview_container == "body") {
		    //Chrome
		    document.body.scrollTop += this_var_checkbox_position;
		    //Firefox
		    document.documentElement.scrollTop += this_var_checkbox_position;
		} else {
		    $(dialog + " #" + treeview_container)[0].scrollTop = this_var_checkbox_position;
		}
		//---------------------------scrolling-----------------------------------//
	    });
	    //if there is only one search result -> go to this without showing the dropdown
	    if (num_search_results == 1) {
	    	var one_search_id = $("#" + search_output + " li").attr("id");
	    	$("#" + one_search_id).trigger("click");
	    }

	});
    }
    //----------------------------search--------------------------------------//
})(jQuery);



</script>


<script type="text/javascript">
    function isTrue(val){
        if(typeof val=='number'){
            return val > 0
        }else if(typeof val=='string'){
            if(val.toLowerCase()=='true') return true
            if(val=='1') return true
            return false
        }else if(typeof val=='boolean'){
            return val
        }
      
        return false
    }
    function setSelectedUnits(unitCodes, unitNames) {
       
        var textCode = '';
        for (var i = 0; i < unitCodes.length; i++) {
            textCode += unitCodes[i];
            if (i < unitCodes.length - 1) textCode += ',';
        }
        $('#unit-codes').val(textCode);

       
       
        var textName = '';
        for (var i = 0; i < unitNames.length; i++) {
            textName += unitNames[i];
            if (i < unitNames.length - 1) textName += ',';
        }


        $('#unit-names').val(textName);

        CloseCustomModal();

        //隱藏err-msg
        $("input[name='Units']").next().hide();
        $('#unit-list').fadeIn();

    }
    function setSelectedClasses(codes, names) {

        var textCode = '';
        for (var i = 0; i < codes.length; i++) {
            textCode += codes[i];
            if (i < codes.length - 1) textCode += ',';
        }
        $('#class-codes').val(textCode);



        var textName = '';
        for (var i = 0; i < names.length; i++) {
            textName += names[i];
            if (i < names.length - 1) textName += ',';
        }


        $('#class-names').val(textName);

        CloseCustomModal();

        //隱藏err-msg
        $("input[name='Classes']").next().hide();
        $('#class-list').fadeIn();

    }
    function getSelectedUnits() {
        return $('#unit-codes').val();
    }
    function getSelectedClasses() {
        return $('#class-codes').val();
    }
   
    function fetchUnits() {

        //var url = 'http://203.64.37.41:9000/api/units';
        var url = 'http://school/api/units';
        return new Promise((resolve, reject) => {
            $.getJSON(url)
             .done(function (data) {
                 createNodeList(data);
                 resolve(true)
             }).fail(function (error) {
                 reject(error);
             });

        })
    }
    function fetchClasses() {
        //var url = 'http://203.64.37.41:9000/api/classes';
        var url = 'http://school/api/classes';
        return new Promise((resolve, reject) => {
            $.getJSON(url)
             .done(function (data) {
                createNodeList(data);
                resolve(true)
             }).fail(function (error) {
                 reject(error);
             });

        })
    }
    function createNodeList(data) {
      
        var html = '';

        for (var i = 0; i < data.length ; i++) {
            html += getNode(data[i]);
        }

        $("#treeview-members").html(html);
    }
    function getNode(unit) {
        var html = '<li>';

        if (unit.children && unit.children.length) {
            html += ' <i class="fa fa-plus"></i>';
            html += '<label>' + '<input data-name="' + unit.name + '"   data-id="' + unit.code + '"   type="checkbox" />'
            html += unit.name + '</label>';
        } else {
            html += '<label>' + '<input data-name="' + unit.name + '"   data-id="' + unit.code + '" class="hummingbirdNoParent"  type="checkbox" />'
            html += unit.name + '</label>';
        }


        if (unit.children && unit.children.length) {
            html += ' <ul>';
            for (var i = 0; i < unit.children.length ; i++) {
                html += getNode(unit.children[i]);
            }
            html += ' </ul>';
        }

        return html;

    }
    function iniUnitsTree() {
        var treeview = $("#treeview-members");
        var type = getSelectType();
    

        var selected_codes = '';
        if (type == 'unit') {
            selected_codes = getSelectedUnits();
        } else {
           
            selected_codes = getSelectedClasses();
        }

        
      
        treeview.hummingbird();

        if (!selected_codes) return;

        var selected_ids = selected_codes.split(',');
        for (var i = 0; i < selected_ids.length; i++) {
            treeview.hummingbird("checkNode", {
                attr: "data-id",
                name: selected_ids[i],
                expandParents: false
            });
        }
        
        //treeview.on("CheckUncheckDone", function () {
        //    var list = [];
        //    treeview.hummingbird("getChecked", {
        //        attr: "id",
        //        list: list,
        //        OnlyFinalInstance: true
        //    });

        //    alert(list.length);

        //});
    }

    

    function onStaffCheckChanged(checked, hideLevels) {
        if (checked) {
            beginSelectUnits(hideLevels);
            $('#err-roles').hide();
        } else {
            $('#unit-names').fadeOut();
        }
    } 
    function onStudentCheckChanged(checked) {
        if (checked) {
            beginSelectClasses();
            $('#err-roles').hide();
        } else {
            $('#class-names').fadeOut();
        }
    } 
    function beginSelectUnits(hideLevels) {
        setSelectType('unit');
      
        var units = fetchUnits();

        units.then(result => {
            iniUnitsTree();
            if (hideLevels) {
                $('#div-level').hide();
            } else {
                $('#div-level').show();
            }
            
            ShowCustomModal('請選擇發送對象部門');
        })
        .catch(error=> {
            OnError();
        })
    }

    function beginSelectClasses() {
        setSelectType('class');

        var classes = fetchClasses();

        classes.then(result => {
            iniUnitsTree();
          
            $('#div-level').hide();
            ShowCustomModal('請選擇發送對象班級');
        })
        .catch(error=> {
            OnError();
        })
    }

    
    function setSelectType(type) {
        $('#select-type').val(type)
    }
    function getSelectType() {
        return $('#select-type').val();
    }
    function onSelectDone() {
       
        var type = getSelectType();
        var id_list = [];
        $("#treeview-members").hummingbird("getChecked", {
            attr: "data-id",
            list: id_list,
            OnlyFinalInstance: true
        });

        if (!id_list.length) {
            if (type == 'unit') alert('請選擇部門');
            else alert('請選擇班級');

            return false;
        }

        var name_list = [];
        $("#treeview-members").hummingbird("getChecked", {
            attr: "data-name",
            list: name_list,
            OnlyFinalInstance: true
        });

        

        if (type == 'unit') {
            setSelectedUnits(id_list, name_list);
            
            setLevels();
        } else {
            setSelectedClasses(id_list, name_list);
        }
       

    }

    function setLevels()
    {
        var ids = '';
        if ($('#level-one').prop("checked")) ids = '1';

        if ($('#level-two').prop("checked")) {
            if (ids) ids += ',';

            ids += '2';
        }

        $("input[name='Levels']").val(ids);

        setLevelsText();
      

    }
    function setLevelsText() {
        var levels = $("input[name='Levels']").val();
        var text = '';
        if (levels) {
            var lavel_ids = levels.split(',');
            if (lavel_ids.indexOf('1') > -1) text += '一級主管';

            if (lavel_ids.indexOf('2') > -1) {
                if (text) text += ',';
                text += '二級主管';
            }

        }

        if (text) text = ' ( ' + text + ' )';

        $('#level-text').text(text);

       
      
    }
    function onLevelChanged(val, checked) {

        var levels = $("input[name='Levels']").val();
        if (checked) {
            if (levels) levels += ',' ;
            levels += val;
        } else {
            levels = levels.replace(val, ''); 
            if (levels.startsWith(',')) levels = levels.slice(0, 1);
            if (levels.endsWith(',')) levels = levels.slice(0, -1);
        }
        $("input[name='Levels']").val(levels);
    }

   
    function CloseCustomModal() {
        $('#close-custom-modal').click();
    }

    function ShowCustomModal(title) {
        SetCustomModalTitle(title)
        $('#open-custom-modal').click();
    }

    function SetCustomModalTitle(title) {
        $('#custom-modal-title').text(title);
    }

    function ShowAlert(content,showBtn) {
        $('#alert-content').html(content);

        if (showBtn) {
            $('#alert-footer').show();
        } else {
            $('#alert-footer').hide();
        }
        $('#btn-alert-modal').click();
    }
   

    function OnError() {
        alert('系統發生錯誤, 請稍後再試');
    }

   
    function clearErrorMsg(target) {
       
        if (target.name == 'Content') {
            var inputContent = $("textarea[name='Content']");
            inputContent.next().hide();

            return;
        }


        var input = $("input[name='" + target.name + "']");
        
        input.next().hide();
     
    }
    function showErrors(msgs) {
        if (!msgs.length) return;
        var html = '<ul>';
        for (var i = 0; i < msgs.length; i++) {
            html += '<li>' + msgs[i] + '</li>';
           
        }

        html += '</ul>';

        var showBtn = false;
        ShowAlert(html, showBtn)
    }

    //$("input[type='checkbox'][name='Student']").change(function () {
    //    var checked = $(this).prop("checked");
    //    $(this).val(checked);
    //    onStudentCheckChanged(checked);
    //});

    
    $(document).ready(function () {
        $("input[type='checkbox'][name='Staff']").change(function () {
            var checked = $(this).prop("checked");
            $(this).val(checked);
            onStaffCheckChanged(checked);
        });
       
        $("input[type='checkbox'][name='Teacher']").change(function () {
            var checked = $(this).prop("checked");
            $(this).val(checked);
            var hideLevels=true;
            onStaffCheckChanged(checked, hideLevels);
        });
        $("input[type='checkbox'][name='Student']").change(function () {
            var checked = $(this).prop("checked");
            $(this).val(checked);
            onStudentCheckChanged(checked);
        });

        //$('.chk-levels').change(function () {
        //    var checked = $(this).prop("checked");
        //    var val = $(this).val();
        //    onLevelChanged(val ,checked);
        //});
       


        $('#btn-select-done').click(function () {
            onSelectDone();
        });
        $('#tree-select-all').click(function () {
            $("#treeview-members").hummingbird("checkAll");
        });
        $('#tree-cancel-all').click(function () {
            $("#treeview-members").hummingbird("uncheckAll");
        });


        $('#btn-edit-units').click(function (e) {
            e.preventDefault();
            beginSelectUnits();
        });

        $('#btn-edit-classes').click(function (e) {
            e.preventDefault();
            beginSelectClasses();
        });

        $('#form-notice').submit(function (e) {
          
             var canSubmit = true;
             var errMsgs = [];
             var inputContent = $("textarea[name='Content']");            
             if (!inputContent.val()) {
                 canSubmit = false;
                 inputContent.next().show();
                 errMsgs.push(inputContent.next().text());
             }

             if (document.getElementById('attachment-file').files.length) {
                 var inputAttachmentTitle = $("input[name='Attachment_Title']");   
                 if (!inputAttachmentTitle.val()) {
                     canSubmit = false;
                     inputAttachmentTitle.next().show();
                     errMsgs.push(inputAttachmentTitle.next().text());
                 }
             }

             var student = isTrue($("input[type='checkbox'][name='Student']").val());
             var teacher = isTrue($("input[type='checkbox'][name='Teacher']").val());
             var staff = isTrue($("input[type='checkbox'][name='Staff']").val());

             if (!student && !teacher && !staff) {
                 $('#err-roles').show();
                 errMsgs.push($('#err-roles').text());
                 canSubmit = false;
             }

             if (student) {
                 var  classes= $("input[name='Classes']").val();
                 if (!classes) {
                     canSubmit = false;
                     $('#class-list').fadeIn();
                     $("input[name='Classes']").next().show();
                     errMsgs.push($("input[name='Classes']").next().text());
                 }

             }

             if (teacher || staff) {
                 var units = $("input[name='Units']").val();
                 if (!units) {
                     canSubmit = false;
                     $('#unit-list').fadeIn();
                     $("input[name='Units']").next().show();
                     errMsgs.push($("input[name='Units']").next().text());
                 }

             }

             if (!canSubmit) {
                 showErrors(errMsgs);

                 return false;
             } 

             alert('submit');

             if (!student) {
                 $("input[name='Classes']").val('');
                 
             }

             if (!staff && !teacher) {
                 $("input[name='Units']").val('');
                 $("input[name='Levels']").val('');

             }


          

            

          
        });

        $('#form-notice').keydown(function () {
            clearErrorMsg(event.target);
        });

       
        
    });




</script>
