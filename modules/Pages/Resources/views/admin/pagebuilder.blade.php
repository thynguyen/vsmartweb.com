@extends('pages::admin.master')
@section('metatitle',AdminFunc::ReturnModule('Pages','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_pages_main')}}
@endsection
@section('header')
<link href="{!!asset('modules/js/pages/builder/libs/codemirror/lib/codemirror.css')!!}" rel="stylesheet"/>
<link href="{!!asset('modules/js/pages/builder/libs/codemirror/theme/material.css')!!}" rel="stylesheet"/>
<link href="{!!asset('modules/js/pages/builder/css/editor.css')!!}" rel="stylesheet">
<link href="{!!asset('modules/js/pages/builder/css/line-awesome.css')!!}" rel="stylesheet">
<link href="{{ asset('css/pnotify.custom.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div id="vvveb-builder" class="no-right-panel">
   <div id="top-panel">
      <div class="mx-3" role="group">
         <!-- <button class="btn btn-outline-secondary" title="{!!transmod('Pages::TemplatesManager')!!}" id="toggle-file-manager-btn" data-vvveb-action="toggleFileManager" data-toggle="button" aria-pressed="true">
         <i class="fal fa-layer-group fa-fw"></i>
         </button> -->
         <button class="btn btn-outline-secondary" title="{!!transmod('Pages::ToggleLeftColumn')!!}" id="toggle-left-column-btn" data-vvveb-action="toggleLeftColumn" data-toggle="button" aria-pressed="false">
         <i class="fal fa-arrow-alt-to-left fa-fw"></i>
         </button>
         <button class="btn btn-outline-secondary" title="{!!transmod('Pages::Undo')!!}" id="undo-btn" data-vvveb-action="undo" data-vvveb-shortcut="ctrl+z">
         <i class="fal fa-arrow-left fa-fw"></i>
         </button>
         <button class="btn btn-outline-secondary"  title="{!!transmod('Pages::Redo')!!}" id="redo-btn" data-vvveb-action="redo" data-vvveb-shortcut="ctrl+shift+z">
         <i class="fal fa-arrow-right fa-fw"></i>
         </button>
         <button class="btn btn-outline-secondary" title="{!!transmod('Pages::DesignerMode')!!}" id="designer-mode-btn" data-toggle="button" aria-pressed="false" data-vvveb-action="setDesignerMode">
         <i class="fal fa-hand-rock fa-fw"></i>
         </button>
         <button class="btn btn-outline-secondary" title="{!!transmod('Pages::Preview')!!}" id="preview-btn" type="button" data-toggle="button" aria-pressed="false" data-vvveb-action="preview">
         <i class="fal fa-eye fa-fw"></i>
         </button>
         <button class="btn btn-outline-secondary" title="{!!transmod('Pages::Fullscreen')!!}" id="fullscreen-btn" data-toggle="button" aria-pressed="false" data-vvveb-action="fullscreen">
         <i class="fal fa-expand-arrows fa-fw"></i>
         </button>
      </div>
      <div>
         <img src="{{ asset('modules/js/pages/builder/img/logo_vsw.png') }}" alt="V-Smart Web Builder" class="img-fluid" id="logo">
      </div>
      <div class="mx-3 responsive-btns" role="group">
         <button class="btn btn-dark btn-icon btn-sm" title="{!!trans('Langcore::global.Back')!!}" onclick="redirectroute('{!!route('pages.admin.main')!!}');">
         <span data-v-gettext><i class="fal fa-home"></i></span>
         </button>
         <button class="btn btn-success btn-icon btn-sm" title="{!!trans('Langcore::global.Back')!!}" onclick="redirectroute('{!!route('pages.admin.chooseinterface',['id'=>$page->id])!!}');">
         <span data-v-gettext><i class="fal fa-layer-group mr-1"></i>{!!transmod('Pages::Templates')!!}</span>
         </button>
         <button class="btn btn-primary btn-icon btn-sm" title="{!!trans('Langcore::global.Save')!!}" id="save-btn" data-vvveb-action="saveAjax2" data-vvveb-url="{!!route('pages.admin.addcontent',$page->id)!!}" data-v-vvveb-shortcut="ctrl+e">
         <span data-v-gettext><i class="fal fa-save mr-1"></i>{!!trans('Langcore::global.Save')!!}</span>
         </button>
      </div>
   </div>
   <div id="left-panel">
      <div id="filemanager">
         <div class="header">
            <a href="#" class="text-secondary">{!!transmod('Pages::Templates')!!}</a>
         </div>
         <div class="tree">
            <ol>
            </ol>
         </div>
      </div>
      <div class="drag-elements">
         <div class="header">
            <ul class="nav nav-tabs  nav-fill" id="elements-tabs" role="tablist">
               <li class="nav-item component-tab">
                  <a class="nav-link active" id="components-tab" data-toggle="tab" href="#components" role="tab" aria-controls="components" aria-selected="true" title="{!!transmod('Pages::Components')!!}">
                     <img src="{!!asset('modules/js/pages/builder/libs/builder/icons/product.svg')!!}" height="23"> 
                     <div><small>{!!transmod('Pages::Components')!!}</small></div>
                  </a>
               </li>
               <li class="nav-item blocks-tab">
                  <a class="nav-link" id="blocks-tab" data-toggle="tab" href="#blocks" role="tab" aria-controls="blocks" aria-selected="false" title="{!!transmod('Pages::Sections')!!}">
                     <img src="{!!asset('modules/js/pages/builder/libs/builder/icons/list_group.svg')!!}" height="23"> 
                     <div><small>{!!transmod('Pages::Sections')!!}</small></div>
                  </a>
               </li>
               <li class="nav-item component-properties-tab" style="display:none">
                  <a class="nav-link" id="properties-tab" data-toggle="tab" href="#properties" role="tab" aria-controls="blocks" aria-selected="false" title="{!!transmod('Pages::Properties')!!}">
                     <img src="{!!asset('modules/js/pages/builder/libs/builder/icons/filters.svg')!!}" height="23"> 
                     <div><small>{!!transmod('Pages::Properties')!!}</small></div>
                  </a>
               </li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane fade show active" id="components" role="tabpanel" aria-labelledby="components-tab">
                  <div class="search">
                     <input class="form-control form-control-sm component-search" placeholder="{!!transmod('Pages::SearchComponents')!!}" type="text" data-vvveb-action="componentSearch" data-vvveb-on="keyup">
                     <button class="clear-backspace"  data-vvveb-action="clearComponentSearch">
                     <i class="la la-close"></i>
                     </button>
                  </div>
                  <div class="drag-elements-sidepane sidepane">
                     <div>
                        <ul class="components-list clearfix" data-type="leftpanel">
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="blocks" role="tabpanel" aria-labelledby="blocks-tab">
                  <ul class="nav nav-tabs nav-fill sections-tabs" id="properties-tabs" role="tablist">
                     <li class="nav-item content-tab">
                        <a class="d-flex justify-content-center align-items-center nav-link active" data-toggle="tab" href="#sections-new-tab" role="tab" aria-controls="components" aria-selected="true">
                           <i class="la la-plus mr-1"></i> 
                           <div><span>{!!transmod('Pages::AddSection')!!}</span></div>
                        </a>
                     </li>
                     <li class="nav-item style-tab">
                        <a class="d-flex justify-content-center align-items-center nav-link" data-toggle="tab" href="#sections-list" role="tab" aria-controls="blocks" aria-selected="false">
                           <i class="la la-bars mr-1"></i> 
                           <div><span>{!!transmod('Pages::PageSections')!!}</span></div>
                        </a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane fade show active" id="sections-new-tab" data-section="content" role="tabpanel" aria-labelledby="content-tab">
                        <div class="search">
                           <input class="form-control form-control-sm block-search" placeholder="{!!transmod('Pages::SearchComponents')!!}" type="text" data-vvveb-action="blockSearch" data-vvveb-on="keyup">
                           <button class="clear-backspace"  data-vvveb-action="clearBlockSearch">
                           <i class="la la-close"></i>
                           </button>
                        </div>
                        <div class="drag-elements-sidepane sidepane">
                           <div>
                              <ul class="blocks-list clearfix" data-type="leftpanel">
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade show" id="sections-list" data-section="style" role="tabpanel" aria-labelledby="style-tab">
                        <div class="sections"></div>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="blocks-tab">
                  <div class="component-properties-sidepane">
                     <div>
                        <div class="component-properties">
                           <ul class="nav nav-tabs nav-fill" id="properties-tabs" role="tablist">
                              <li class="nav-item content-tab">
                                 <a class="nav-link active" data-toggle="tab" href="#content-left-panel-tab" role="tab" aria-controls="components" aria-selected="true">
                                    <div><span>{!!transmod('Pages::Content')!!}</span></div>
                                 </a>
                              </li>
                              <li class="nav-item style-tab">
                                 <a class="nav-link" data-toggle="tab" href="#style-left-panel-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                    <div><span>Style</span></div>
                                 </a>
                              </li>
                              <li class="nav-item advanced-tab">
                                 <a class="nav-link" data-toggle="tab" href="#advanced-left-panel-tab" role="tab" aria-controls="blocks" aria-selected="false">
                                    <div><span>{!!transmod('Pages::Advanced')!!}</span></div>
                                 </a>
                              </li>
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane fade show active" id="content-left-panel-tab" data-section="content" role="tabpanel" aria-labelledby="content-tab">
                                 <div class="mt-4 text-center">{!!transmod('Pages::ClickElementEdit')!!}</div>
                              </div>
                              <div class="tab-pane fade show" id="style-left-panel-tab" data-section="style" role="tabpanel" aria-labelledby="style-tab">
                              </div>
                              <div class="tab-pane fade show" id="advanced-left-panel-tab" data-section="advanced"  role="tabpanel" aria-labelledby="advanced-tab">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="canvas">
      <div id="iframe-wrapper">
         <div id="iframe-layer">
            <div id="highlight-box">
               <div id="highlight-name"></div>
               <div id="section-actions">
                  <a id="add-section-btn" href="" title="Add element"><i class="la la-plus"></i></a>
               </div>
            </div>
            <div id="select-box">
               <div id="wysiwyg-editor">
                  <a id="bold-btn" href="" title="Bold"><i class="la la-bold"></i></a>
                  <a id="italic-btn" href="" title="Italic"><i class="la la-italic"></i></a>
                  <a id="underline-btn" href="" title="Underline"><i class="la la-underline"></i></a>
                  <a id="strike-btn" href="" title="Strikeout"><del>S</del></a>
                  <a id="link-btn" href="" title="Create link"><i class="la la-link"></i></a>
                  <div class="dropdown">
                     <a class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="la la-align-left"></i>
                     </a>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#"><i class="la la-lg la-align-left"></i> Align Left</a>
                        <a class="dropdown-item" href="#"><i class="la la-lg la-align-center"></i> Align Center</a>
                        <a class="dropdown-item" href="#"><i class="la la-lg la-align-right"></i> Align Right</a>
                        <a class="dropdown-item" href="#"><i class="la la-lg la-align-justify"></i> Align Justify</a>
                     </div>
                  </div>
                  <input name="color" type="color" pattern="#[a-f0-9]{6}" class="form-control">
                  <select class="custom-select">
                     <option value="">Default</option>
                     <option value="Arial, Helvetica, sans-serif">Arial</option>
                     <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Grande</option>
                     <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype</option>
                     <option value="'Times New Roman', Times, serif">Times New Roman</option>
                     <option value="Georgia, serif">Georgia, serif</option>
                     <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                     <option value="'Comic Sans MS', cursive, sans-serif">Comic Sans</option>
                     <option value="Verdana, Geneva, sans-serif">Verdana</option>
                     <option value="Impact, Charcoal, sans-serif">Impact</option>
                     <option value="'Arial Black', Gadget, sans-serif">Arial Black</option>
                     <option value="'Trebuchet MS', Helvetica, sans-serif">Trebuchet</option>
                     <option value="'Courier New', Courier, monospace">Courier New</option>
                     <option value="'Brush Script MT', sans-serif">Brush Script</option>
                  </select>
               </div>
               <div id="select-actions">
                  <a id="drag-btn" href="" title="Drag element"><i class="la la-arrows"></i></a>
                  <a id="parent-btn" href="" title="Select parent"><i class="la la-level-down la-rotate-180"></i></a>
                  <a id="up-btn" href="" title="Move element up"><i class="la la-arrow-up"></i></a>
                  <a id="down-btn" href="" title="Move element down"><i class="la la-arrow-down"></i></a>
                  <a id="clone-btn" href="" title="Clone element"><i class="la la-copy"></i></a>
                  <a id="delete-btn" href="" title="Remove element"><i class="la la-trash"></i></a>
               </div>
            </div>
            <!-- add section box -->
            <div id="add-section-box" class="drag-elements">
               <div class="header">
                  <ul class="nav nav-tabs" id="box-elements-tabs" role="tablist">
                     <li class="nav-item component-tab">
                        <a class="nav-link active" id="box-components-tab" data-toggle="tab" href="#box-components" role="tab" aria-controls="components" aria-selected="true">
                           <i class="la la-lg la-cube"></i> 
                           <div><small>{!!transmod('Pages::Components')!!}</small></div>
                        </a>
                     </li>
                     <li class="nav-item blocks-tab">
                        <a class="nav-link" id="box-blocks-tab" data-toggle="tab" href="#box-blocks" role="tab" aria-controls="blocks" aria-selected="false">
                           <i class="la la-lg la-image"></i> 
                           <div><small>{!!transmod('Pages::Sections')!!}</small></div>
                        </a>
                     </li>
                  </ul>
                  <div class="section-box-actions">
                     <div id="close-section-btn" class="btn btn-light btn-sm bg-white btn-sm float-right"><i class="la la-close"></i></div>
                     <div class="small mt-1 mr-3 float-right">
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="add-section-insert-mode-after" value="after" checked="checked" name="add-section-insert-mode" class="custom-control-input">
                           <label class="custom-control-label" for="add-section-insert-mode-after">{!!transmod('Pages::After')!!}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                           <input type="radio" id="add-section-insert-mode-inside" value="inside" name="add-section-insert-mode" class="custom-control-input">
                           <label class="custom-control-label" for="add-section-insert-mode-inside">{!!transmod('Pages::Inside')!!}</label>
                        </div>
                     </div>
                  </div>
                  <div class="tab-content">
                     <div class="tab-pane fade show active" id="box-components" role="tabpanel" aria-labelledby="components-tab">
                        <div class="search">
                           <input class="form-control form-control-sm component-search" placeholder="{!!transmod('Pages::SearchComponents')!!}" type="text" data-vvveb-action="addBoxComponentSearch" data-vvveb-on="keyup">
                           <button class="clear-backspace"  data-vvveb-action="clearComponentSearch">
                           <i class="la la-close"></i>
                           </button>
                        </div>
                        <div>
                           <div>
                              <ul class="components-list clearfix" data-type="addbox">
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="box-blocks" role="tabpanel" aria-labelledby="blocks-tab">
                        <div class="search">
                           <input class="form-control form-control-sm block-search" placeholder="{!!transmod('Pages::SearchBlocks')!!}" type="text" data-vvveb-action="addBoxBlockSearch" data-vvveb-on="keyup">
                           <button class="clear-backspace"  data-vvveb-action="clearBlockSearch">
                           <i class="la la-close"></i>
                           </button>
                        </div>
                        <div>
                           <div>
                              <ul class="blocks-list clearfix"  data-type="addbox">
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- //add section box -->
         </div>
         <iframe src="about:none" id="iframe1"></iframe>
      </div>
   </div>
   <div id="right-panel">
      <div class="component-properties">
         <ul class="nav nav-tabs nav-fill" id="properties-tabs" role="tablist">
            <li class="nav-item content-tab">
               <a class="nav-link active" data-toggle="tab" href="#content-tab" role="tab" aria-controls="components" aria-selected="true">
                  <i class="la la-lg la-cube"></i> 
                  <div><span>{!!transmod('Pages::Content')!!}</span></div>
               </a>
            </li>
            <li class="nav-item style-tab">
               <a class="nav-link" data-toggle="tab" href="#style-tab" role="tab" aria-controls="blocks" aria-selected="false">
                  <i class="la la-lg la-image"></i> 
                  <div><span>Style</span></div>
               </a>
            </li>
            <li class="nav-item advanced-tab">
               <a class="nav-link" data-toggle="tab" href="#advanced-tab" role="tab" aria-controls="blocks" aria-selected="false">
                  <i class="la la-lg la-cog"></i> 
                  <div><span>Advanced</span></div>
               </a>
            </li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane fade show active" id="content-tab" data-section="content" role="tabpanel" aria-labelledby="content-tab">
            </div>
            <div class="tab-pane fade show" id="style-tab" data-section="style" role="tabpanel" aria-labelledby="style-tab">
            </div>
            <div class="tab-pane fade show" id="advanced-tab" data-section="advanced"  role="tabpanel" aria-labelledby="advanced-tab">
            </div>
         </div>
      </div>
   </div>
   <div id="bottom-panel">
      <div class="d-flex justify-content-between align-items-center">
         <div class="btn-group" role="group">
            <button id="code-editor-btn" data-view="mobile" class="btn btn-sm btn-light btn-sm"  title="{!!transmod('Pages::CodeEditor')!!}" data-vvveb-action="toggleEditor">
            <i class="la la-code"></i> {!!transmod('Pages::CodeEditor')!!}
            </button>
            <div id="toggleEditorJsExecute" class="custom-control custom-checkbox mt-1" style="display:none">
               <input type="checkbox" class="custom-control-input" id="customCheck" name="example1" data-vvveb-action="toggleEditorJsExecute">
               <label class="custom-control-label" for="customCheck"><small>{!!transmod('Pages::RunJavascript')!!}</small></label>
            </div>
         </div>
         <div>
            <button id="mobile-view" data-view="mobile" class="btn btn-outline-secondary"  title="{!!transmod('Pages::MobileView')!!}" data-vvveb-action="viewport">
            <i class="fal fa-mobile fa-fw"></i>
            </button>
            <button id="tablet-view"  data-view="tablet" class="btn btn-outline-secondary"  title="{!!transmod('Pages::TabletView')!!}" data-vvveb-action="viewport">
            <i class="fal fa-mobile fa-rotate-90 fa-fw"></i>
            </button>
            <button id="desktop-view"  data-view="" class="btn btn-outline-secondary"  title="{!!transmod('Pages::DesktopView')!!}" data-vvveb-action="viewport">
            <i class="fal fa-laptop fa-fw"></i>
            </button>
         </div>
         <small class="mr-2">
            <a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" target="_black">{{config('app.vswver')}}</a>
            <span>© All Rights Reserved.</span>
         </small>
      </div>
      <div id="vvveb-code-editor">
         <textarea class="form-control"></textarea>
         <div>
         </div>
      </div>
   </div>
   <!-- templates -->
   <script id="vvveb-input-textinput" type="text/html">
      <div>
         <input name="{%=key%}" type="text" class="form-control"/>
      </div>
      
   </script>
   <script id="vvveb-input-textareainput" type="text/html">
      <div>
         <textarea name="{%=key%}" rows="3" class="form-control"/>
      </div>
      
   </script>
   <script id="vvveb-input-checkboxinput" type="text/html">
      <div class="custom-control custom-checkbox">
           <input name="{%=key%}" class="custom-control-input" type="checkbox" id="{%=key%}_check">
           <label class="custom-control-label" for="{%=key%}_check">{% if (typeof text !== 'undefined') { %} {%=text%} {% } %}</label>
      </div>
      
   </script>
   <script id="vvveb-input-radioinput" type="text/html">
      <div>
      
         {% for ( var i = 0; i < options.length; i++ ) { %}
      
         <label class="custom-control custom-radio  {% if (typeof inline !== 'undefined' && inline == true) { %}custom-control-inline{% } %}"  title="{%=options[i].title%}">
           <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
           <label class="custom-control-label" for="{%=key%}{%=i%}">{%=options[i].text%}</label>
         </label>
      
         {% } %}
      
      </div>
      
   </script>
   <script id="vvveb-input-radiobuttoninput" type="text/html">
      <div class="btn-group btn-group-toggle  {%if (extraclass) { %}{%=extraclass%}{% } %} clearfix" data-toggle="buttons">
      
         {% for ( var i = 0; i < options.length; i++ ) { %}
      
         <label class="btn  btn-outline-primary  {%if (options[i].checked) { %}active{% } %}  {%if (options[i].extraclass) { %}{%=options[i].extraclass%}{% } %}" for="{%=key%}{%=i%} " title="{%=options[i].title%}">
           <input name="{%=key%}" class="custom-control-input" type="radio" value="{%=options[i].value%}" id="{%=key%}{%=i%}" {%if (options[i].checked) { %}checked="{%=options[i].checked%}"{% } %}>
           {%if (options[i].icon) { %}<i class="{%=options[i].icon%}"></i>{% } %}
           {%=options[i].text%}
         </label>
      
         {% } %}
               
      </div>
      
   </script>
   <script id="vvveb-input-toggle" type="text/html">
      <div class="toggle">
          <input 
      type="checkbox" 
      name="{%=key%}" 
      value="{%=on%}" 
      {%if (off) { %} data-value-off="{%=off%}" {% } %}
      {%if (on) { %} data-value-on="{%=on%}" {% } %} 
      class="toggle-checkbox" 
      id="{%=key%}">
          <label class="toggle-label" for="{%=key%}">
              <span class="toggle-inner"></span>
              <span class="toggle-switch"></span>
          </label>
      </div>
      
   </script>
   <script id="vvveb-input-header" type="text/html">
      <h6 class="header">{%=header%}</h6>
      
   </script>
   <script id="vvveb-input-select" type="text/html">
      <div>
      
         <select class="form-control custom-select">
            {% for ( var i = 0; i < options.length; i++ ) { %}
            <option value="{%=options[i].value%}">{%=options[i].text%}</option>
            {% } %}
         </select>
      
      </div>
      
   </script>
   <script id="vvveb-input-dateinput" type="text/html">

      <div>
         <input name="{%=key%}" type="date" class="form-control" 
            {% if (typeof min_date === 'undefined') { %} min="{%=min_date%}" {% } %} {% if (typeof max_date === 'undefined') { %} max="{%=max_date%}" {% } %}
         />
      </div>

   </script>
   <script id="vvveb-input-listinput" type="text/html">
      <div class="row">
      
         {% for ( var i = 0; i < options.length; i++ ) { %}
         <div class="col-6">
            <div class="input-group">
               <input name="{%=key%}_{%=i%}" type="text" class="form-control" value="{%=options[i].text%}"/>
               <div class="input-group-append">
                  <button class="input-group-text btn btn-sm btn-danger">
                     <i class="la la-trash la-lg"></i>
                  </button>
               </div>
              </div>
              <br/>
         </div>
         {% } %}
      
      
         {% if (typeof hide_remove === 'undefined') { %}
         <div class="col-12">
         
            <button class="btn btn-sm btn-outline-primary">
               <i class="la la-trash la-lg"></i> Add new
            </button>
            
         </div>
         {% } %}
            
      </div>
      
   </script>
   <script id="vvveb-input-grid" type="text/html">
      <div class="row">
         <div class="mb-1 col-12">
         
            <label>Flexbox</label>
            <select class="form-control custom-select" name="col">
               
               <option value="">None</option>
               {% for ( var i = 1; i <= 12; i++ ) { %}
               <option value="{%=i%}" {% if ((typeof col !== 'undefined') && col == i) { %} selected {% } %}>{%=i%}</option>
               {% } %}
               
            </select>
            <br/>
         </div>
      
         <div class="col-6">
            <label>Extra small</label>
            <select class="form-control custom-select" name="col-xs">
               
               <option value="">None</option>
               {% for ( var i = 1; i <= 12; i++ ) { %}
               <option value="{%=i%}" {% if ((typeof col_xs !== 'undefined') && col_xs == i) { %} selected {% } %}>{%=i%}</option>
               {% } %}
               
            </select>
            <br/>
         </div>
         
         <div class="col-6">
            <label>Small</label>
            <select class="form-control custom-select" name="col-sm">
               
               <option value="">None</option>
               {% for ( var i = 1; i <= 12; i++ ) { %}
               <option value="{%=i%}" {% if ((typeof col_sm !== 'undefined') && col_sm == i) { %} selected {% } %}>{%=i%}</option>
               {% } %}
               
            </select>
            <br/>
         </div>
         
         <div class="col-6">
            <label>Medium</label>
            <select class="form-control custom-select" name="col-md">
               
               <option value="">None</option>
               {% for ( var i = 1; i <= 12; i++ ) { %}
               <option value="{%=i%}" {% if ((typeof col_md !== 'undefined') && col_md == i) { %} selected {% } %}>{%=i%}</option>
               {% } %}
               
            </select>
            <br/>
         </div>
         
         <div class="col-6 mb-1">
            <label>Large</label>
            <select class="form-control custom-select" name="col-lg">
               
               <option value="">None</option>
               {% for ( var i = 1; i <= 12; i++ ) { %}
               <option value="{%=i%}" {% if ((typeof col_lg !== 'undefined') && col_lg == i) { %} selected {% } %}>{%=i%}</option>
               {% } %}
               
            </select>
            <br/>
         </div>
         
         {% if (typeof hide_remove === 'undefined') { %}
         <div class="col-12">
         
            <button class="btn btn-sm btn-outline-light text-danger">
               <i class="la la-trash la-lg"></i> Remove
            </button>
            
         </div>
         {% } %}
         
      </div>
      
   </script>
   <script id="vvveb-input-textvalue" type="text/html">
      <div class="row">
         <div class="col-6 mb-1">
            <label>Value</label>
            <input name="value" type="text" value="{%=value%}" class="form-control"/>
         </div>
      
         <div class="col-6 mb-1">
            <label>Text</label>
            <input name="text" type="text" value="{%=text%}" class="form-control"/>
         </div>
      
         {% if (typeof hide_remove === 'undefined') { %}
         <div class="col-12">
         
            <button class="btn btn-sm btn-outline-light text-danger">
               <i class="la la-trash la-lg"></i> Remove
            </button>
            
         </div>
         {% } %}
      
      </div>
      
   </script>
   <script id="vvveb-input-rangeinput" type="text/html">
      <div>
         <input name="{%=key%}" type="range" min="{%=min%}" max="{%=max%}" step="{%=step%}" class="form-control"/>
      </div>
      
   </script>
   <script id="vvveb-input-imageinput" type="text/html">
      <div>
         <input name="{%=key%}" type="text" class="form-control"/>
         <input name="file" type="file" class="form-control"/>
      </div>
      
   </script>
   <script id="vvveb-input-colorinput" type="text/html">
      <div>
         <input name="{%=key%}" type="color" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}  pattern="#[a-f0-9]{6}" class="form-control"/>
      </div>
      
   </script>
   <script id="vvveb-input-bootstrap-color-picker-input" type="text/html">
      <div>
         <div id="cp2" class="input-group" title="Using input value">
           <input name="{%=key%}" type="text" {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %}    class="form-control"/>
           <span class="input-group-append">
            <span class="input-group-text colorpicker-input-addon"><i></i></span>
           </span>
         </div>
      </div>
      
   </script>
   <script id="vvveb-input-numberinput" type="text/html">
      <div>
         <input name="{%=key%}" type="number" value="{%=value%}" 
              {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %} 
              {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %} 
              {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %} 
         class="form-control"/>
      </div>
   </script>
   <script id="vvveb-input-button" type="text/html">
      <div>
         <button class="btn btn-sm btn-primary">
            <i class="la  {% if (typeof icon !== 'undefined') { %} {%=icon%} {% } else { %} la-plus {% } %} la-lg"></i> {%=text%}
         </button>
      </div>      
   </script>
   <script id="vvveb-input-cssunitinput" type="text/html">
      <div class="input-group" id="cssunit-{%=key%}">
         <input name="number" type="number"  {% if (typeof value !== 'undefined' && value != false) { %} value="{%=value%}" {% } %} 
              {% if (typeof min !== 'undefined' && min != false) { %}min="{%=min%}"{% } %} 
              {% if (typeof max !== 'undefined' && max != false) { %}max="{%=max%}"{% } %} 
              {% if (typeof step !== 'undefined' && step != false) { %}step="{%=step%}"{% } %} 
         class="form-control"/>
          <div class="input-group-append">
         <select class="form-control custom-select small-arrow" name="unit">
            <option value="em">em</option>
            <option value="px">px</option>
            <option value="%">%</option>
            <option value="rem">rem</option>
            <option value="auto">auto</option>
         </select>
         </div>
      </div>
      
   </script>
   <script id="vvveb-filemanager-folder" type="text/html">
      <li data-folder="{%=folder%}" class="folder">
         <label for="{%=folder%}"><span>{%=folderTitle%}</span></label> <input type="checkbox" id="{%=folder%}" />
         <ol></ol>
      </li>
   </script>
   <script id="vvveb-filemanager-page" type="text/html">
      <li data-url="{%=url%}" data-file="{%=file%}" data-page="{%=name%}" class="file">
         <label for="{%=name%}"><span>{%=title%}</span></label> <input type="checkbox" checked id="{%=name%}" />
         <ol></ol>
      </li>
   </script>
   <script id="vvveb-filemanager-component" type="text/html">
      <li data-url="{%=url%}" data-component="{%=name%}" class="component">
         <a href="{%=url%}"><span>{%=title%}</span></a>
      </li>
   </script>
   <script id="vvveb-input-sectioninput" type="text/html">
      <label class="header" data-header="{%=key%}" for="header_{%=key%}"><span>&ensp;{%=header%}</span> <div class="header-arrow"></div></label> 
      <input class="header_check" type="checkbox" {% if (typeof expanded !== 'undefined' && expanded == false) { %} {% } else { %}checked="true"{% } %} id="header_{%=key%}"> 
      <div class="section" data-section="{%=key%}"></div>      
      
   </script>
   <script id="vvveb-property" type="text/html">
      <div class="form-group {% if (typeof col !== 'undefined' && col != false) { %} col-sm-{%=col%} d-inline-block {% } else { %}row{% } %}" data-key="{%=key%}" {% if (typeof group !== 'undefined' && group != null) { %}data-group="{%=group%}" {% } %}>
         
         {% if (typeof name !== 'undefined' && name != false) { %}<label class="{% if (typeof inline === 'undefined' ) { %}col-sm-4{% } %} control-label" for="input-model">{%=name%}</label>{% } %}
         
         <div class="{% if (typeof inline === 'undefined') { %}col-sm-{% if (typeof name !== 'undefined' && name != false) { %}8{% } else { %}12{% } } %} input"></div>
         
      </div>       
      
   </script>
   <script id="vvveb-input-autocompletelist" type="text/html">
      <div>
         <input name="{%=key%}" type="text" class="form-control"/>
         
         <div class="form-control autocomplete-list" style="min=height: 150px; overflow: auto;">
                       </div>
                       </div>
      
   </script>
   <script id="vvveb-input-tagsinput" type="text/html">
      <div>
         <div class="form-control tags-input" style="height:auto;">
               
      
               <input name="{%=key%}" type="text" class="form-control" style="border:none;min-width:60px;"/>
                       </div>
                       </div>
      
   </script>
   <script id="vvveb-section" type="text/html">
      <div class="section-item">
         <div class="handle"></div>
         <div>
            
            <div class="name">{%=name%} <div class="type">{%=type%}</div></div>
            
         </div>
         <div class="buttons">
            <a class="delete-btn" href="" title="Remove element"><i class="la la-trash text-danger"></i></a>
            <a class="up-btn" href="" title="Move element up"><i class="la la-arrow-up"></i></a>
            <a class="down-btn" href="" title="Move element down"><i class="la la-arrow-down"></i></a>
            <a class="properties-btn" href="" title="{!!transmod('Pages::Properties')!!}"><i class="la la-cog"></i></a>
         </div>
      </div>
      
   </script>
   <!--// end templates -->
   <!-- export html modal-->
   <div class="modal fade" id="textarea-modal" tabindex="-1" role="dialog" aria-labelledby="textarea-modal" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <p class="modal-title text-primary"><i class="la la-lg la-save"></i> Export html</p>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
               </button>
            </div>
            <div class="modal-body">
               <textarea rows="25" cols="150" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="la la-close"></i> Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- message modal-->
   <div class="modal fade" id="message-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <p class="modal-title text-primary"><i class="la la-lg la-comment"></i> V-Smart Web - Web Builder</p>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
               </button>
            </div>
            <div class="modal-body">
               <p>Page was successfully saved!.</p>
            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-primary">Ok</button> -->
               <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="la la-close"></i> Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- new page modal-->
   <div class="modal fade" id="new-page-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <form>
            <div class="modal-content">
               <div class="modal-header">
                  <p class="modal-title text-primary"><i class="la la-lg la-file"></i> New page</p>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><small><i class="la la-close"></i></small></span>
                  </button>
               </div>
               <div class="modal-body text">
                  <div class="form-group row" data-key="type">
                     <label class="col-sm-3 control-label">
                     Template 
                     <abbr class="badge badge-pill badge-secondary" title="This template will be used as a start">?</abbr> 
                     </label>      
                     <div class="col-sm-9 input">
                        <div>
                           <select class="form-control custom-select" name="startTemplateUrl">
                              <option value="new-page-blank-template.html">Blank Template</option>
                              <option value="templates/narrow-jumbotron/index.html">Narrow jumbotron</option>
                              <option value="templates/album/index.html">Album</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row" data-key="href">
                     <label class="col-sm-3 control-label">Page name</label>      
                     <div class="col-sm-9 input">
                        <div>   
                           <input name="title" type="text" class="form-control" placeholder="My page" required>  
                        </div>
                     </div>
                  </div>
                  <div class="form-group row" data-key="href">
                     <label class="col-sm-3 control-label">File name</label>      
                     <div class="col-sm-9 input">
                        <div>   
                           <input name="file" type="text" class="form-control" placeholder="my-page.html" required>  
                        </div>
                     </div>     
                  </div>

                  <div class="form-group row" data-key="href">     
                      <label class="col-sm-3 control-label">Url</label>      
                     <div class="col-sm-9 input">
                        <div>   
                           <input name="url" type="text" class="form-control" placeholder="/my-page.html" required>  
                        </div>
                     </div>     
                  </div>

                  <div class="form-group row" data-key="href">     
                      <label class="col-sm-3 control-label">Folder</label>      
                     <div class="col-sm-9 input">
                        <div>   
                           <input name="folder" type="text" class="form-control" placeholder="/" required>  
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-primary btn-lg" type="submit"><i class="la la-check"></i> Create page</button>
                  <button class="btn btn-secondary btn-lg" type="reset" data-dismiss="modal"><i class="la la-close"></i> Cancel</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection
@section('footer')
<script src="{!!asset('modules/js/pages/builder/js/jquery.hotkeys.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/builder.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/undo.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/inputs.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/components-bootstrap4.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/components-widgets.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/blocks-bootstrap4.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/codemirror/lib/codemirror.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/codemirror/lib/xml.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/codemirror/lib/formatting.js')!!}"></script>
<script src="{!!asset('modules/js/pages/builder/libs/builder/plugin-codemirror.js')!!}"></script>
<script src="{!!asset('modules/js/pages/webbuilder.js.php')!!}"></script>
<script type="text/javascript">
var urluploadfile = '{!!route('pages.admin.uploadfile')!!}';
var linktemplates = @if($page->content && !session('datapagestemp'))
'{!!$contentfile!!}'@else'{!!$datatemp['url']!!}'@endif;
</script>
@endsection