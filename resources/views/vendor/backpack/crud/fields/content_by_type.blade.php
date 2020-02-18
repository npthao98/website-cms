<!-- dependencyJson -->
<style>
    #content0, #content1, #content2, #content3{
        display: none;
    }
</style>
<div class="form-group col-sm-12 checklist_dependency"
{{--     data-entity="{{ $field['field_unique_name'] }}"--}}
     data-init-function="bpFieldInitChecklistDependencyElement"
    @include('crud::inc.field_wrapper_attributes')>
    <label>Type</label>
    @include('crud::inc.field_translatable_icon')
    <?php
//    $entity_model = $crud->getModel();

    //short name for dependency fields
    $primary_dependency = [
        'name' => 'type',
        'label' => 'Type',
        'options'     => [
            0 => "Text",
            1 => "Photo",
            2 => "Video",
            3 => "Gallery",
            4 => "Infographics"
        ],
    ];
    $secondary_dependency =[
        'name' => 'content',
        'label' => 'Content',
        ];

    //all items with relation
//    $dependencies = $primary_dependency['model']::with($primary_dependency['entity_secondary'])->get();
//
//    $dependencyArray = [];
//
//    //convert dependency array to simple matrix ( prymary id as key and array with secondaries id )
//    foreach ($dependencies as $primary) {
//        $dependencyArray[$primary->id] = [];
//        foreach ($primary->{$primary_dependency['entity_secondary']} as $secondary) {
//            $dependencyArray[$primary->id][] = $secondary->id;
//        }
//    }

    //for update form, get initial state of the entity
//    if (isset($id) && $id) {
//
//        //get entity with relations for primary dependency
//        $entity_dependencies = $entity_model->with($primary_dependency['entity'])
//            ->with($primary_dependency['entity'].'.'.$primary_dependency['entity_secondary'])
//            ->find($id);
//
//        $secondaries_from_primary = [];
//
//        //convert relation in array
//        $primary_array = $entity_dependencies->{$primary_dependency['entity']}->toArray();
//
//        $secondary_ids = [];
//
//        //create secondary dependency from primary relation, used to check what chekbox must be check from second checklist
//        if (old($primary_dependency['name'])) {
//            foreach (old($primary_dependency['name']) as $primary_item) {
//                foreach ($dependencyArray[$primary_item] as $second_item) {
//                    $secondary_ids[$second_item] = $second_item;
//                }
//            }
//        } else { //create dependecies from relation if not from validate error
//            foreach ($primary_array as $primary_item) {
//                foreach ($primary_item[$secondary_dependency['entity']] as $second_item) {
//                    $secondary_ids[$second_item['id']] = $second_item['id'];
//                }
//            }
//        }
//    }

    //json encode of dependency matrix
//    $dependencyJson = json_encode($dependencyArray);
    ?>

    <div class="container">

{{--        <div class="row">--}}

{{--            <div class="col-sm-12">--}}
{{--                <label>type</label>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row">

            <div class="hidden_fields_primary" data-name = "{{ $primary_dependency['name'] }}">

                @if(isset($field['value']))
                    @if(old($primary_dependency['name']))
                        @foreach( old($primary_dependency['name']) as $item )
                            <input type="hidden" class="primary_hidden" name="{{ $primary_dependency['name'] }}" value="{{ $item }}">
                        @endforeach
                    @else
                        @foreach( $field['value'][0]->pluck('id', 'id')->toArray() as $item )
                            <input type="hidden" class="primary_hidden" name="{{ $primary_dependency['name'] }}" value="{{ $item }}">
                        @endforeach
                    @endif
                @else
                    <input type="hidden" class="primary_hidden" name="{{ $primary_dependency['name'] }}" id="input-type">
{{--                    <input type="hidden" class="secondary_dependency" name="{{ $secondary_dependency['name'] }}" value="jsdskdsk">--}}
                @endif
            </div>
            <?php $k = 0; ?>
            @foreach ($primary_dependency['options'] as $connected_entity_entry)
                <div class="col-sm-{{ isset($primary_dependency['number_columns']) ? intval(12/$primary_dependency['number_columns']) : '4'}}">
                    <div class="checkbox">
                        <label class="font-weight-normal">
                            <input type="radio"
                                   name="mother"
                                   id = "{{$connected_entity_entry}}"
                                   data-id = "{{ $k }}"
                                   class = 'primary_list'
{{--                            @foreach ($primary_dependency as $attribute => $value)--}}
{{--                                @if (is_string($attribute) && $attribute != 'value')--}}
{{--                                    @if ($attribute=='name')--}}
{{--                                        {{ $attribute }}="{{ $value }}_show[]"--}}
{{--                                    @else--}}
{{--                                        {{ $attribute }}="{{ $value }}"--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
                            value="{{ $k++ }}"

                            @if( ( isset($field['value']) && is_array($field['value']) && in_array($connected_entity_entry->id, $field['value'][0]->pluck('id', 'id')->toArray())) || ( old($primary_dependency["name"]) && in_array($connected_entity_entry->id, old( $primary_dependency["name"])) ) )
                                checked = "checked"
                            @endif >
                            {{ $connected_entity_entry }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="hidden_fields_secondary" data-name="{{ $secondary_dependency['name'] }}">
                @if(isset($field['value']))
                    @if(old($secondary_dependency['name']))
                        @foreach( old($secondary_dependency['name']) as $item )
                            <input type="hidden" class="secondary_hidden" name="{{ $secondary_dependency['name'] }}[]" value="{{ $item }}">
                        @endforeach
                    @else
                        @foreach( $field['value'][1]->pluck('id', 'id')->toArray() as $item )
                            <input type="hidden" class="secondary_hidden" name="{{ $secondary_dependency['name'] }}[]" value="{{ $item }}">
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div><!-- /.container -->


    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>

{{--images --}}
@php
    $multiple = array_get($secondary_dependency, 'multiple', true);
    $sortable = array_get($secondary_dependency, 'sortable', false);
    $value = old(square_brackets_to_dots($secondary_dependency['name'])) ?? $secondary_dependency['value'] ?? $secondary_dependency['default'] ?? '';

    if (!$multiple && is_array($value)) {
        $value = array_first($value);
    }

    if (!isset($secondary_dependency['wrapperAttributes']) || !isset($secondary_dependency['wrapperAttributes']['data-init-function']))
    {
        $secondary_dependency['wrapperAttributes']['data-init-function'] = 'bpFieldInitBrowseMultipleElement';

        if ($multiple) {
            $secondary_dependency['wrapperAttributes']['data-popup-title'] = trans('backpack::crud.select_files');
            $secondary_dependency['wrapperAttributes']['data-multiple'] = "true";
        } else {
            $secondary_dependency['wrapperAttributes']['data-popup-title'] = trans('backpack::crud.select_file');
            $secondary_dependency['wrapperAttributes']['data-multiple'] = "false";
        }

        if ($mimes = array_get($secondary_dependency, 'mime_types')) {
            $secondary_dependency['wrapperAttributes']['data-only-mimes'] = json_encode($mimes);
        }

        if($sortable){
            $secondary_dependency['wrapperAttributes']['sortable'] = "true";
        }
    }
@endphp

<div @include('crud::inc.field_wrapper_attributes') id="content1">

    <div><label>Images</label></div>
    @include('crud::inc.field_translatable_icon')
    @if ($multiple)
        <div class="list">
            @foreach( (array)$value as $v)
                @if ($v)
                    <div class="input-group input-group-sm">
                        <input type="text" name="{{ $secondary_dependency['name'] }}[]" value="{{ $v }}" data-marker="multipleBrowseInput"
                               @include('crud::inc.field_attributes') readonly>
                        <div class="input-group-btn">
                            <button type="button" class="browse remove btn btn-sm btn-light">
                                <i class="fa fa-trash"></i>
                            </button>
                            @if ($sortable)
                                <button type="button" class="browse move btn btn-sm btn-light"><span class="fa fa-sort"></span></button>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <input type="text" name="{{ $secondary_dependency['name'] }}" value="{{ $value }}" @include('crud::inc.field_attributes') readonly>
    @endif

    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" class="browse popup btn btn-sm btn-light">
            <i class="fa fa-cloud-upload"></i>
            {{ trans('backpack::crud.browse_uploads') }}
        </button>
        <button type="button" class="browse clear btn btn-sm btn-light">
            <i class="fa fa-eraser"></i>
            {{ trans('backpack::crud.clear') }}
        </button>
    </div>

    @if (isset($secondary_dependency['hint']))
        <p class="help-block">{!! $secondary_dependency['hint'] !!}</p>
    @endif

    <script type="text/html" data-marker="browse_multiple_template">
        <div class="input-group input-group-sm">
            <input type="text" name="{{ $secondary_dependency['name'] }}[]" @include('crud::inc.field_attributes') readonly>
            <div class="input-group-btn">
                <button type="button" class="browse remove btn btn-sm btn-light">
                    <i class="fa fa-trash"></i>
                </button>
                @if ($sortable)
                    <button type="button" class="browse move btn btn-sm btn-light"><span class="fa fa-sort"></span></button>
                @endif
            </div>
        </div>
    </script>
</div>

{{--images--}}
{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- include browse server css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('packages/jquery-ui-dist/jquery-ui.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/elfinder.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/theme.css') }}">
        <link href="{{ asset('packages/jquery-colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
        <style>
            #cboxContent, #cboxLoadedContent, .cboxIframe {
                background: transparent;
            }
        </style>
    @endpush

    @push('crud_fields_scripts')
        <!-- include browse server js -->
        <script src="{{ asset('packages/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('packages/jquery-colorbox/jquery.colorbox-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>
        {{-- <script type="text/javascript" src="{{ asset('packages/barryvdh/elfinder/js/extras/editors.default.min.js') }}"></script> --}}
        @if ( ($locale = \App::getLocale()) != 'en' )
            {{--            @php--}}
            <script type="text/javascript" src="{{ asset("packages/barryvdh/elfinder/js/i18n/elfinder.{$locale}.js") }}"></script>
        @endif

        <script>
            function bpFieldInitBrowseMultipleElement(element) {
                var $template = element.find("[data-marker=browse_multiple_template]").html();
                var $list = element.find(".list");
                var $popupButton = element.find(".popup");
                var $clearButton = element.find(".clear");
                var $removeButton = element.find(".remove");
                var $input = element.find('input[data-marker=multipleBrowseInput]');
                var $popupTitle = element.attr('data-popup-title');
                var $onlyMimesArray = element.attr('data-only-mimes');
                var $multiple = element.attr('data-multiple');
                var $sortable = element.attr('sortable');

                if($sortable){
                    $list.sortable({
                        handle: 'button.move',
                        cancel: ''
                    });
                }

                element.on('click', 'button.popup', function (event) {
                    event.preventDefault();

                    var div = $('<div>');
                    div.elfinder({
                        lang: '{{ \App::getLocale() }}',
                        customData: {
                            _token: '{{ csrf_token() }}'
                        },
                        url: '{{ route("elfinder.connector") }}',
                        soundPath: '{{ asset('/packages/barryvdh/elfinder/sounds') }}',
                        dialog: {
                            width: 900,
                            modal: true,
                            title: $popupTitle,
                        },
                        resizable: false,
                        onlyMimes: $onlyMimesArray,
                        commandsOptions: {
                            getfile: {
                                multiple: $multiple,
                                oncomplete: 'destroy'
                            }
                        },
                        getFileCallback: function (files) {
                            if ($multiple) {
                                files.forEach(function (file) {
                                    var newInput = $($template);
                                    newInput.find('input').val(file.path);
                                    $list.append(newInput);
                                });

                                if($sortable){
                                    $list.sortable("refresh")
                                }
                            } else {
                                $input.val(files.path);
                            }

                            $.colorbox.close();
                        }
                    }).elfinder('instance');

                    // trigger the reveal modal with elfinder inside
                    $.colorbox({
                        href: div,
                        inline: true,
                        width: '80%',
                        height: '80%'
                    });
                });

                element.on('click', 'button.clear', function (event) {
                    event.preventDefault();

                    if ($multiple) {
                        $input.parents('.input-group').remove();
                    } else {
                        $input.val('');
                    }
                });

                if ($multiple) {
                    element.on('click', 'button.remove', function (event) {
                        event.preventDefault();
                        $(this).parents('.input-group').remove();
                    });
                }
            }
        </script>
    @endpush
@endif
{{--end images--}}
{{--images--}}


{{--image--}}

<!-- browse server input -->

<div @include('crud::inc.field_wrapper_attributes')  id="content2">

    <label>Image</label>
    @include('crud::inc.field_translatable_icon')
    <div class="controls">
	    <div class="input-group">
			<input
				type="text"
				id="{{ $secondary_dependency['name'] }}-filemanager"
				name="{{ $secondary_dependency['name'] }}"
		        value="{{ old(square_brackets_to_dots($secondary_dependency['name'])) ?? $secondary_dependency['value'] ?? $secondary_dependency['default'] ?? '' }}"
		        data-init-function="bpFieldInitBrowseElement"
		        data-elfinder-trigger-url="{{ url(config('elfinder.route.prefix').'/popup') }}"
		        @include('crud::inc.field_attributes')

				@if(!isset($secondary_dependency['readonly']) || $secondary_dependency['readonly']) readonly @endif
			>

			<span class="input-group-append">
			  	<button type="button" data-inputid="{{ $secondary_dependency['name'] }}-filemanager" class="btn btn-light btn-sm popup_selector"><i class="fa fa-cloud-upload"></i> {{ trans('backpack::crud.browse_uploads') }}</button>
				<button type="button" data-inputid="{{ $secondary_dependency['name'] }}-filemanager" class="btn btn-light btn-sm clear_elfinder_picker"><i class="fa fa-eraser"></i> {{ trans('backpack::crud.clear') }}</button>
			</span>
		</div>
	</div>

	@if (isset($secondary_dependency['hint']))
        <p class="help-block">{!! $secondary_dependency['hint'] !!}</p>
    @endif

</div>


{{--end image--}}

<!-- CKeditor and video-->
<?php

$value = old(square_brackets_to_dots($secondary_dependency['name'])) ?? $secondary_dependency['value'] ?? $secondary_dependency['default'] ?? '';

// if attribute casting is used, convert to JSON
if (is_array($value)) {
    $value = json_encode((object) $value);
} elseif (is_object($value)) {
    $value = json_encode($value);
} else {
    $value = $value;
}

?>

<!--view video-->
<div data-video data-init-function="bpFieldInitVideoElement" @include('crud::inc.field_wrapper_attributes') id="content0" >
    @include('crud::inc.field_translatable_icon')
    <label>Video</label>
    <input class="video-json" type="hidden" name="{{ $secondary_dependency['name'] }}" value="{{ $value }}">
    <div class="input-group">
        <input @include('crud::inc.field_attributes', ['default_class' => 'video-link form-control']) type="url" id="{{ $secondary_dependency['name'] }}_link">
        <div class="input-group-append video-previewSuffix video-noPadding">
            <div class="video-preview">
                <span class="video-previewImage"></span>
                <a class="video-previewLink hidden" target="_blank" href="">
                    <i class="fa fa-lg video-previewIcon"></i>
                </a>
            </div>
            <div class="video-dummy">
                <a class="video-previewLink youtube dummy" target="_blank" href="https://www.youtube.com/">
                    <i class="fa fa-lg fa-youtube video-previewIcon dummy"></i>
                </a>
                <a class="video-previewLink vimeo dummy" target="_blank" href="https://vimeo.com/">
                    <i class="fa fa-lg fa-vimeo video-previewIcon dummy"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($secondary_dependency['hint']))
        <p class="help-block">{!! $secondary_dependency['hint'] !!}</p>
    @endif
</div>


{{--view text--}}
<div @include('crud::inc.field_wrapper_attributes') id = "content3">
    <label>Text</label>
    @include('crud::inc.field_translatable_icon')
    <textarea
        id="ckeditor-{{ $secondary_dependency['name'] }}"
        name="{{ $secondary_dependency['name'] }}"
        data-init-function="bpFieldInitCKEditorElement"
        @include('crud::inc.field_attributes', ['default_class' => 'form-control'])
    	>{{ old(square_brackets_to_dots($secondary_dependency['name'])) ?? $secondary_dependency['value'] ?? $secondary_dependency['default'] ?? '' }}</textarea>

    {{-- HINT --}}
    @if (isset($secondary_dependency['hint']))
        <p class="help-block">{!! $secondary_dependency['hint'] !!}</p>
    @endif
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
{{--        video--}}
        {{-- @push('crud_fields_styles')
        {{-- YOUR CSS HERE --}}
        <style media="screen">
            .video-previewSuffix {
                border: 0;
                min-width: 68px; }
            .video-noPadding {
                padding: 0; }
            .video-preview {
                display: none; }
            .video-previewLink {
                color: #fff;
                display: block;
                width: 2.375rem; height: 2.375rem;
                text-align: center;
                float: left; }
            .video-previewLink.youtube {
                background: #DA2724; }
            .video-previewLink.vimeo {
                background: #00ADEF; }
            .video-previewIcon {
                transform: translateY(7px); }
            .video-previewImage {
                float: left;
                display: block;
                width: 2.375rem; height: 2.375rem;
                background-size: cover;
                background-position: center center; }
        </style>

{{--        end video--}}

{{--        image--}}
        <!-- include browse server css -->
		<link href="{{ asset('packages/jquery-colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
		<style>
			#cboxContent, #cboxLoadedContent, .cboxIframe {
				background: transparent;
			}
		</style>
{{--    end image--}}
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
{{--    video--}}
        <script>
            var tryYouTube = function( link ){

                var id = null;

                // RegExps for YouTube link forms
                var youtubeStandardExpr = /^https?:\/\/(www\.)?youtube.com\/watch\?v=([^?&]+)/i; // Group 2 is video ID
                var youtubeAlternateExpr = /^https?:\/\/(www\.)?youtube.com\/v\/([^\/\?]+)/i; // Group 2 is video ID
                var youtubeShortExpr = /^https?:\/\/youtu.be\/([^\/]+)/i; // Group 1 is video ID
                var youtubeEmbedExpr = /^https?:\/\/(www\.)?youtube.com\/embed\/([^\/]+)/i; // Group 2 is video ID

                var match = link.match(youtubeStandardExpr);

                if (match != null){
                    id = match[2];
                }
                else {
                    match = link.match(youtubeAlternateExpr);

                    if (match != null) {
                        id = match[2];
                    }
                    else {
                        match = link.match(youtubeShortExpr);

                        if (match != null){
                            id = match[1];
                        }
                        else {
                            match = link.match(youtubeEmbedExpr);

                            if (match != null){
                                id = match[2];
                            }
                        }
                    }
                }

                return id;
            };

            var tryVimeo = function( link ){

                var id = null;
                var regExp = /(http|https):\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;

                var match = link.match(regExp);

                if (match){
                    id = match[3];
                }

                return id;
            };

            var fetchYouTube = function( videoId, callback ){

                var api = 'https://www.googleapis.com/youtube/v3/videos?id='+videoId+'&key=AIzaSyDQa76EpdNPzfeTAoZUut2AnvBA0jkx3FI&part=snippet';

                var video = {
                    provider: 'youtube',
                    id: null,
                    title: null,
                    image: null,
                    url: null
                };

                $.getJSON(api, function( data ){

                    if (typeof(data.items[0]) != "undefined") {
                        var v = data.items[0].snippet;

                        video.id = videoId;
                        video.title = v.title;
                        video.image = v.thumbnails.maxres ? v.thumbnails.maxres.url : v.thumbnails.default.url;
                        video.url = 'https://www.youtube.com/watch?v=' + video.id;

                        callback(video);
                    }
                });
            };

            var fetchVimeo = function( videoId, callback ){

                var api = 'https://vimeo.com/api/v2/video/' + videoId + '.json?callback=?';

                var video = {
                    provider: 'vimeo',
                    id: null,
                    title: null,
                    image: null,
                    url: null
                };

                $.getJSON(api, function( data ){

                    if (typeof(data[0]) != "undefined") {
                        var v = data[0];

                        video.id = v.id;
                        video.title = v.title;
                        video.image = v.thumbnail_large || v.thumbnail_small;
                        video.url = v.url;

                        callback(video);
                    }
                });
            };

            var parseVideoLink = function( link, callback ){

                var response = {success: false, message: 'unknown error occured, please try again', data: [] };

                try {
                    var parser = document.createElement('a');
                } catch(e){
                    response.message = 'Please post a valid youtube/vimeo url';
                    return response;
                }


                var id = tryYouTube(link);

                if( id ){

                    return fetchYouTube(id, function(video){

                        if( video ){
                            response.success = true;
                            response.message = 'video found';
                            response.data = video;
                        }

                        callback(response);
                    });
                }
                else {

                    id = tryVimeo(link);

                    if( id ){

                        return fetchVimeo(id, function(video){

                            if( video ){
                                response.success = true;
                                response.message = 'video found';
                                response.data = video;
                            }

                            callback(response);
                        });
                    }
                }

                response.message = 'We could not detect a YouTube or Vimeo ID, please try obtain the URL again'
                return callback(response);
            };

            var updateVideoPreview = function(video, container){

                var pWrap = container.find('.video-preview'),
                    pLink = container.find('.video-previewLink').not('.dummy'),
                    pImage = container.find('.video-previewImage').not('dummy'),
                    pIcon  = container.find('.video-previewIcon').not('.dummy'),
                    pSuffix = container.find('.video-previewSuffix'),
                    pDummy  = container.find('.video-dummy');

                pDummy.hide();

                pLink
                    .attr('href', video.url)
                    .removeClass('youtube vimeo hidden')
                    .addClass(video.provider);

                pImage
                    .css('backgroundImage', 'url('+video.image+')');

                pIcon
                    .removeClass('fa-vimeo fa-youtube')
                    .addClass('fa-' + video.provider);
                pWrap.fadeIn();
            };

            var videoParsing = false;

            function bpFieldInitVideoElement(element) {
                var $this = element,
                    jsonField = $this.find('.video-json'),
                    linkField = $this.find('.video-link'),
                    pDummy = $this.find('.video-dummy'),
                    pWrap = $this.find('.video-preview');

                try {
                    var videoJson = JSON.parse(jsonField.val());
                    jsonField.val( JSON.stringify(videoJson) );
                    linkField.val( videoJson.url );
                    updateVideoPreview(videoJson, $this);
                }
                catch(e){
                    pDummy.show();
                    pWrap.hide();
                    jsonField.val('');
                    linkField.val('');
                }

                linkField.on('focus', function(){
                    linkField.originalState = linkField.val();
                });

                linkField.on('change', function(){

                    if( linkField.originalState != linkField.val() ){

                        if( linkField.val().length ){

                            videoParsing = true;

                            parseVideoLink( linkField.val(), function( videoJson ){

                                if( videoJson.success ){
                                    linkField.val( videoJson.data.url );
                                    jsonField.val( JSON.stringify(videoJson.data) );
                                    updateVideoPreview(videoJson.data, $this);
                                }
                                else {
                                    pDummy.show();
                                    pWrap.hide();
                                    new Noty({
                                        type: "error",
                                        text: videoJson.message
                                    }).show();
                                }

                                videoParsing = false;
                            });
                        }
                        else {
                            videoParsing = false;
                            jsonField.val('');
                            $this.find('.video-preview').fadeOut();
                            pDummy.show();
                            pWrap.hide();
                        }
                    }
                });
            }

            jQuery(document).ready(function($) {
                $('form').on('submit', function(e){
                    if( videoParsing ){
                        new Noty({
                            type: "error",
                            text: "<strong>Please wait.</strong><br>Video details are still loading, please wait a moment or try again."
                        }).show();
                        e.preventDefault();
                        return false;
                    }
                })
            });
        </script>
{{--        end video--}}
{{--        text--}}
        <script src="{{ asset('packages/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('packages/ckeditor/adapters/jquery.js') }}"></script>
        <script>
            function bpFieldInitCKEditorElement(element) {
                // remove any previous CKEditors from right next to the textarea
                element.siblings("[id^='cke_ckeditor']").remove();

                // trigger a new CKEditor
                element.ckeditor({
                    "filebrowserBrowseUrl": "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                    "extraPlugins" : '{{ isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : 'embed,widget' }}',
                    "embed_provider": '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'
                    @if (isset($field['options']) && count($field['options']))
                    {!! ', '.trim(json_encode($field['options']), "{}") !!}
                    @endif
                });
            }
        </script>
{{--        end text--}}

{{--image--}}

    <!-- include browse server js -->
		<script src="{{ asset('packages/jquery-colorbox/jquery.colorbox-min.js') }}"></script>
		<script type="text/javascript">
			// this global variable is used to remember what input to update with the file path
			// because elfinder is actually loaded in an iframe by colorbox
			var elfinderTarget = false;

			// function to update the file selected by elfinder
			function processSelectedFile(filePath, requestingField) {
				elfinderTarget.val(filePath.replace(/\\/g,"/"));
				elfinderTarget = false;
			}

			function bpFieldInitBrowseElement(element) {
				var triggerUrl = element.data('elfinder-trigger-url')
				var name = element.attr('name');

				element.siblings('.input-group-append').children('button.popup_selector').click(function (event) {
				    event.preventDefault();

				    elfinderTarget = element;

				    // trigger the reveal modal with elfinder inside
				    $.colorbox({
				        href: triggerUrl + '/' + name,
				        fastIframe: true,
				        iframe: true,
				        width: '80%',
				        height: '80%'
				    });
				});

				element.siblings('.input-group-append').children('button.clear_elfinder_picker').click(function (event) {
				    event.preventDefault();
				    element.val("");
				});
			}
		</script>
{{--end image--}}
    @endpush

@endif

{{-- end ckeditor and video--}}
{{--checkbox--}}
@if ($crud->checkIfFieldIsFirstOfItsType($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include checklist_dependency js-->
        <script>
            function bpFieldInitChecklistDependencyElement(element) {

                // var unique_name = element.data('entity');
                // console.log(unique_name);
                // var dependencyJson = window[unique_name];
                var ar = [
                    [3],[3],[0,3],[1,3],[2,3],
                ];
                var listType = [0,1,2,3];
                console.log(listType);
                var thisField = element;
                thisField.find('.primary_list').change(function(){
                    //remove
                    var secondary = listType;
                    console.log(secondary);

                    $.each(secondary, function(index, secondaryItem){
                        document.getElementById("content"+secondaryItem).style.display = "none";
                        // thisField.find('input.secondary_list[value="'+secondaryItem+'"]').prop('checked', false);
                        // thisField.find('input.secondary_list[value="'+secondaryItem+'"]').prop('disabled', false);

                    });

                    //add
                    var idCurrent = $(this).data('id');
                    // hidden field with this value;
                    var type;
                    if(idCurrent == 0) type = "text";
                    else if(idCurrent == 1) type = "photo";
                    else if(idCurrent == 2) type = "video";
                    else if(idCurrent == 3) type = "gallery";
                    else type = "infographics";
                    document.getElementById("input-type").value= type;
                    $.each(ar[idCurrent], function(key, value){
                        console.log(key);
                        console.log(value);
                        //check and disable secondies checkbox
                        document.getElementById("content"+value).style.display = "block";
                        // thisField.find('input.secondary_list[value="'+value+'"]').prop( "checked", true );
                        // thisField.find('input.secondary_list[value="'+value+'"]').prop( "disabled", true );
                        //remove hidden fields with secondary dependency if was setted
                        var hidden = thisField.find('input.secondary_hidden[value="'+value+'"]');
                        if(hidden)
                            hidden.remove();
                    });
                });


                thisField.find('.secondary_list').click(function(){

                    var idCurrent = $(this).data('id');
                    if($(this).is(':checked')){
                        //add hidden field with this value
                        var nameInput = thisField.find('.hidden_fields_secondary').data('name');
                        var inputToAdd = $('<input type="hidden" class="secondary_hidden" name="'+nameInput+'[]" value="'+idCurrent+'">');

                        thisField.find('.hidden_fields_secondary').append(inputToAdd);

                    }else{
                        //remove hidden field with this value
                        thisField.find('input.secondary_hidden[value="'+idCurrent+'"]').remove();
                    }
                });

            }
        </script>
    @endpush

@endif

{{--end checkbox--}}


