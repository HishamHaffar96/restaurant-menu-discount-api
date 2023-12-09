<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.category.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.category.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.category.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" v-validate="''" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
        <div v-if="errors.has('description')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('description') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('parent_id'), 'has-success': fields.parent_id && fields.parent_id.valid }">
    <label for="parent_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.category.columns.parent_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.parent_id" :options="categories" :multiple="false" track-by="id" label="name" tag-placeholder="{{ __('Select Parent Category') }}" placeholder="{{ __('Parent Category') }}">
        </multiselect>

        {{-- <input type="text" v-model="form.parent_id" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('parent_id'), 'form-control-success': fields.parent_id && fields.parent_id.valid}" id="parent_id" name="parent_id" placeholder="{{ trans('admin.category.columns.parent_id') }}"> --}}
        <div v-if="errors.has('parent_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('parent_id') }}</div>
    </div>
</div>

{{-- <div class="form-group row align-items-center" :class="{'has-danger': errors.has('position'), 'has-success': fields.position && fields.position.valid }">
    <label for="position" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.category.columns.position') }}</label>
<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
    <input type="text" v-model="form.position" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('position'), 'form-control-success': fields.position && fields.position.valid}" id="position" name="position" placeholder="{{ trans('admin.category.columns.position') }}">
    <div v-if="errors.has('position')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('position') }}</div>
</div>
</div> --}}
