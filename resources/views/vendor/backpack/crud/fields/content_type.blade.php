<?php
    $entity = $crud->entry;
    if(isset($field['field']['name']) && isset($entity->type)){
        $field['field']['value'] = $entity->type;
    }
?>
<div class="form-group checklist_dependency"
     data-init-function="bpFieldInitCheck"
    @include('crud::inc.field_wrapper_attributes')>
    <div>
        @include('crud::fields.radio', ['field' => $field['field']])
    </div>
    @foreach($field['dependencies'] as $type => $subField)
        <?php
            if(isset($subField['field']['name'])){
                if($subField['field']['name']=='gallery_id')
                    $subField['field']['entity'] = 'category';
                $name = $subField['field']['name'];
            }
            if(isset($entity->$name))
                $subField['field']['value'] = $entity->$name;
        ?>
        <div id="type_{{$type}}" class="sub_field_content_type" style="display: none;">
            @if(isset($subField['view']))
                @include($subField['view'], ['field' => $subField['field']])
            @endif
        </div>

    @endforeach
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    @push('crud_fields_scripts')
        <script>
            $('input[name=type]').on('click', function () {
                if ($(this).prop('checked') == true) {
                    $('.sub_field_content_type').hide();
                    $('#type_' + $(this).val()).show();
                    $('#type_text').show();
                }
            })
            function bpFieldInitCheck() {
                let check = $("input[name=type]:checked").val();
                $('.sub_field_content_type').hide();
                $('#type_' + check).show();
                $('#type_text').show();
            }
        </script>
    @endpush
@endif
