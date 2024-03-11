<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SubNavigation extends Component
{
    public $title;
    public function render()
    {

        $title = $this->title;

        // THIS SHOULD BE CONDITIONED BASE ON THE TITLE OF THE PAGE - IT MUST BE THE USER ROLES SOON CHANGE THIS TO USE ROLES-TENANT
        if($title == 'Dashboard'){
            $sub_navigation = [
                ['name' => 'Dashboard', 'path' => 'dashboard', 'to' => 'dashboard' ],
            ];
        }
        if(
                $title == 'Products' || 
                $title == 'Product Logs' || 
                $title == 'Barcodes' || 
                $title == 'Sales' || 
                $title == 'Outgoing-Summary' ||
                $title == 'Complete Packaging' ||
                $title == 'Generate Barcode' ||
                $title == 'Monthly Outgoing Summary' ||
                $title == 'Add New Product' ||
                $title == 'On Stock' ||
                $title == 'Outgoing Products' ||
                $title == 'Update-Details' ||
                $title == 'Delivery - Logs' ||
                // $title == 'Sold' ||
                $title == 'Product Summary' ||
                $title == 'Lara' ||
                $title == 'Lara Monthly'
            ){
            $sub_navigation = [
                ['name' => 'Products', 'path' => 'products', 'to' => 'products' ],
                ['name' => 'Barcodes', 'path' => 'list-barcodes', 'to' => 'list-barcodes' ],
                ['name' => 'Product Logs', 'path' => 'product-logs', 'to' => 'product-logs' ],
                ['name' => 'Sales', 'path' => 'sales-logs', 'to' => 'sales-logs' ],
                ['name' => 'Outgoing', 'path' => 'summary-outgoing', 'to' => 'summary-outgoing' ],
                ['name' => 'Delivery Logs', 'path' => 'delivery-logs', 'to' => 'delivery-logs' ],
                // ['name' => 'Sold', 'path' => 'products.sold_per_day', 'to' => 'products.sold_per_day' ],
                ['name' => 'Product Summary', 'path' => 'products.summary_stocks', 'to' => 'products.summary_stocks' ],
                ['name' => 'Lara', 'path' => 'products.lara', 'to' => 'products.lara' ],
            ];
            
        }
        if(
            $title == 'Packaging' ||
            $title == 'Per Day' ||
            $title == 'Materials' || 
            $title == 'Materials-Summary' ||
            $title == 'Add Materials Stock' || 
            $title == 'Deduct Materials Stock'
            ){
            $sub_navigation = [
                ['name' => 'Packaging', 'path' => 'packaging', 'to' => 'packaging' ],
                ['name' => 'Per Day', 'path' => 'packaging-per-day', 'to' => 'packaging-per-day' ],
                ['name' => 'Materials', 'path' => 'material-logs', 'to' => 'material-logs' ],
                ['name' => 'Summary', 'path' => 'summary-materials', 'to' => 'summary-materials' ],
            ];
            
        }
        if($title == 'Inventory'){
            $sub_navigation = [
                ['name' => 'Inventory', 'path' => 'inventory', 'to' => 'inventory' ]
            ];
            
        }
        // if($title == 'Users' || $title == 'Create User' || $title == 'Create Roles'){
        //     $sub_navigation = [
        //         ['name' => 'Create User', 'path' => 'create-user', 'to' => 'create-user' ],
        //         ['name' => 'Create Roles', 'path' => 'create-roles', 'to' => 'create-roles' ]
        //     ];
            
        // }
        // dd($sub_navigation);

        return view('livewire.components.sub-navigation', [
            'title' => $this->title,
            'sub_navigation' => $sub_navigation
        ]);
    }
}
