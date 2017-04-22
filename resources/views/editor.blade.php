<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Editor</title>
	<!--Include relevent scripts (font-awesome (icons), fonts, css, javascript)-->
	<script src="https://use.fontawesome.com/5f362bc36d.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('css/editor.css')}}">
    <script type="text/javascript" src="{{url('js/editor.js')}}"></script>
    </head>
<!--Calls a function to initiate the editor and find any relevant information in the cahce-->
<body onload="loadEditor();">
@include('nav')
<div class="editor__container">
    {{--If we have an error flash message--}}
    @if(isset($error))
        <div class="error">
             <div class="editor__container__error">
                <div class="editor__container__error__item"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;{{ $error }}</div>
            </div><br />
    @endif
    @if (count($errors) > 0)
       @foreach ($errors->all() as $error)
            <div class="editor__container__error">
                <div class="editor__container__error__item"><i class="fa fa-exclamation" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;{{ $error }}</div>
            </div><br />
        @endforeach
    @endif
	<input type="text" id="title" class="editor__container__title" placeholder="Title"><br />
    <!--Toolbar each has a link which calls relevant function and uses font-awesome icon-->
	<div class="editor__container__toolbar">
    	<div class="section">
    		<a href="javascript:void(0)" onclick="rule('bold');"><i class="fa fa-lg fa-bold"></i></a>
    		<a href="javascript:void(0)" onclick="rule('italic');"><i class="fa fa-italic fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('underline');"><i class="fa fa-underline fa-lg"></i></a>
    		<a href="#linkInput" onclick="ShowLinkPopup();"><i class="fa fa-link fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('formatBlock', '<h2>');"><i class="fa fa-header fa-lg"></i></a>    	
    		<a href="javascript:void(0)" onclick="rule('cut');"><i class="fa fa-scissors fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('copy');"><i class="fa fa-files-o fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('justifyLeft');"><i class="fa fa-align-left fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('justifyCenter');"><i class="fa fa-align-center fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('justifyRight');"><i class="fa fa-align-right fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('undo');"><i class="fa fa-arrow-left fa-lg"></i></a>
    		<a href="javascript:void(0)" onclick="rule('redo');"><i class="fa fa-arrow-right fa-lg"></i></a>
    	</div>

    </div>
    <!--The writing bit-->
    <div id="content" class="editor__container__content" spellcheck="true" contenteditable="true">Write...</div><br />
    <input type="text" id="tags" class="editor__container__tags" placeholder="Separate, tags, by, commas" /><br />
    <!--Options for what user can do with the post.-->
	<div class="button__container">
        <a href="javascript:void(0)" onclick="saveAsDraft();" class="styledButton">Save</a>
    	<a href="javascript:void(0)" onclick="removeDraft();" class="styledButton">Discard</a>
    	<a href="javascript:void(0)" onclick="submit();" class="styledButton">Publish</a>
    </div>
    <!--Link popup-->
	<div id="linkInput" class="link__container">
	<div class="link__container__popup">
		<div class="link__container__popup__header"><h2>Enter Url</h2></div><br />
		<input type="text" name="url" id="url" class="link__container__popup__input" placeholder="...">
		<a href="#" onclick="createLink()">Enter</a><a href="#">Quit</a>
	</div>	
    </div>
</div>

<!--
    This form is hidden from the user, when the user finishes a post, 
    the information is put into this form and sent off to the server
-->
<form id="form" action="{{url('/create')}}" method="post">
    <input type="text" id="hidden-area-title" name="title" style="display: none;" />
    <textarea id="hidden-area-contents" name="contents" style="display: none;"></textarea>
    <input type="text" id="hidden-area-tags" name="tags" style="display: none;" />
    <!--CSRF token for security, can be defined as unauthorized commands that are performed on behalf of an authenticated user.-->
     <input type="hidden" name="_token" value="{{ csrf_token() }}"><br /><br />
</form>

</body>
</html>