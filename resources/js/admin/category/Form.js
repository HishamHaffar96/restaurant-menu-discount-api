import AppForm from '../app-components/Form/AppForm';

Vue.component('category-form', {
    props: [
        'categories'
    ],
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                name: '',
                description: '',
                parent_id: '',
            },
            mediaCollections: ['gallery']
        }
    },
    watch: {
        form: {
            handler(newFormState, oldFormState) {

                const selectedCategory = this.findCategoryById(newFormState.parent_id);

                if (selectedCategory) {

                    this.updateSelectedCategory(selectedCategory);
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

        updateSelectedCategory(selectedCategory) {
            // Update the form's selected category with the found category
            this.form.parent_id = selectedCategory;
        }
    }

});
