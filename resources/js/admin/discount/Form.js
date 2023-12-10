import AppForm from '../app-components/Form/AppForm';

Vue.component('discount-form', {
    mixins: [AppForm],
    props: [
        'categories',
        'items',
        'types'
    ],
    data: function () {
        return {
            form: {
                type: '',
                amount: 0.00,
                category_id: '',
                item_id: '',
                discountable_id: '',
            },

        }
    },
    watch: {
        form: {
            handler(newFormState, oldFormState) {

                const selectedType = this.findType(newFormState.type);
                const selectedCategory = this.findCategoryById(newFormState.discountable_id);
                const selectedItem = this.findItemById(newFormState.discountable_id);

                if (selectedType) {

                    this.updateSelectedType(selectedType);
                }
                if (selectedCategory && selectedType.name == "category") {

                    this.updateSelectedCategory(selectedCategory);
                }
                if (selectedItem && selectedType.name == "item") {

                    this.updateSelectedItem(selectedItem);
                }

                // Call your function here
            },
            immediate: true
        }
    },

    methods: {
        findCategoryById(categoryId) {
            // Find the category in the list based on the provided category ID
            return this.categories.find(category => category.id === categoryId);
        },
        findItemById(itemId) {
            // Find the item in the list based on the provided item ID
            return this.items.find(item => item.id === itemId);
        },
        findType(typeName) {
            // Find the type in the list based on the provided type name
            return this.types.find(type => type.name === typeName);
        },

        updateSelectedCategory(selectedCategory) {
            // Update the form's selected category with the found category
            this.form.category_id = selectedCategory;
        },
        updateSelectedItem(selectedItem) {
            // Update the form's selected item with the found item
            this.form.item_id = selectedItem;
        },
        updateSelectedType(selectedType) {
            // Update the form's selected type with the found category
            this.form.type = selectedType;
        }
    }

});
