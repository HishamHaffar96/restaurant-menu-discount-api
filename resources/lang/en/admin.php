<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'category' => [
        'title' => 'Categories',

        'actions' => [
            'index' => 'Categories',
            'create' => 'New Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'hierarchical_data' => 'Hierarchical data',
            'parent_id' => 'Parent',
            'position' => 'Position',

        ],
    ],

    'item' => [
        'title' => 'Items',

        'actions' => [
            'index' => 'Items',
            'create' => 'New Item',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'image' => 'Image',
            'category_id' => 'Category',

        ],
    ],

    'discount' => [
        'title' => 'Discounts',

        'actions' => [
            'index' => 'Discounts',
            'create' => 'New Discount',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'traget'=>'Traget',
            'type'=>'Type',
            'amount'=>'Amount',
            'category_id'=>'Category',
            'item_id'=>'Item',
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
