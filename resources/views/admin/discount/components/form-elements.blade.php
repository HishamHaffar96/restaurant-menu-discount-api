<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discount.columns.type') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.type" :options="types" :multiple="false" track-by="name" label="name" tag-placeholder="{{ __('Select Type') }}" placeholder="{{ __('Type') }}">
        </multiselect>

        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('amount'), 'has-success': fields.amount && fields.amount.valid }">
    <label for="amount" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discount.columns.amount') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.amount" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('amount'), 'form-control-success': fields.amount && fields.amount.valid}" id="amount" name="amount" placeholder="{{ trans('admin.discount.columns.amount') }}">
        <div v-if="errors.has('amount')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('amount') }}</div>
    </div>
</div>

<div v-if="form.type.name=='item'" class="form-group row align-items-center" :class="{'has-danger': errors.has('item_id'), 'has-success': fields.item_id && fields.item_id.valid }">
    <label for="item_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discount.columns.item_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.item_id" :options="items" :multiple="false" track-by="id" label="name" tag-placeholder="{{ __('Select Item') }}" placeholder="{{ __('Item') }}">
        </multiselect>
        <div v-if="errors.has('item_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('item_id') }}</div>
    </div>
</div>

<div v-if="form.type.name=='category'" class="form-group row align-items-center" :class="{'has-danger': errors.has('category_id'), 'has-success': fields.category_id && fields.category_id.valid }">
    <label for="category_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discount.columns.category_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.category_id" :options="categories" :multiple="false" track-by="id" label="name" tag-placeholder="{{ __('Select  Category') }}" placeholder="{{ __(' Category') }}">
        </multiselect>
        <div v-if="errors.has('category_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('category_id') }}</div>
    </div>
</div>
