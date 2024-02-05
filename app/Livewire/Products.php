<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\Products as Product;
use Illuminate\Support\Facades\Auth;

#[Title('Products')]
class Products extends Component
{
    use WithPagination;

    public $product_id;

    #[Rule('required|max:15')] 
    public $product_sku;

    #[Rule('required|max:15')] 
    public $model;

    #[Rule('required|max:15')] 
    public $color;

    #[Rule('required|max:15')] 
    public $size;

    #[Rule('required|max:15')] 
    public $heel_height;

    #[Rule('required|max:15')] 
    public $category;

    #[Rule('required|max:15')] 
    public $price;

    #[Rule('required|max:15')] 
    public $stocks;

    // FILTERS - SEARCH
    public $product_sku_search = '';
    public $model_search = '';
    public $color_search = '';
    public $size_search = '';
    public $heel_search = '';
    public $category_search = '';

    public $filterProducts = 0;

    public $cart = [];

    public function addToCart($product){
        // Check if the product with the same ID already exists in the cart
        $existingItem = array_search($product['id'], array_column($this->cart, 'id'));

        if ($existingItem !== false) {
            // If the product already exists in the cart, increment the quantity by 1
            $this->cart[$existingItem]['quantity'] += 1;
        } else {
            // If the product does not exist in the cart, add it as a new item with quantity 1
            $product['quantity'] = 1;
            $this->cart[] = $product;
        }
    }

    
    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart); // Re-index the array after removal
        }
        // dd($index);
    }

    public function store(){
        dd($this->cart);
    }

    public function filterStocks($value){
        $this->filterProducts = $value;
    }

    public function addThisStocks(){
        $products = array(
            array('ProductID' => 'CELBLK37N5','Stock' => '1'),
            array('ProductID' => 'CELBLK38N5','Stock' => '1'),
            array('ProductID' => 'CELBLK39N5','Stock' => '6'),
            array('ProductID' => 'CELBLK40N5','Stock' => '17'),
            array('ProductID' => 'CELBLK41N5','Stock' => '15'),
            array('ProductID' => 'CELBLK42N5','Stock' => '6'),
            array('ProductID' => 'CELBLK43N5','Stock' => '7'),
            array('ProductID' => 'CELBLK44N5','Stock' => '13'),
            array('ProductID' => 'CELBLK45N5','Stock' => '8'),
            array('ProductID' => 'CELCAR37N5','Stock' => '2'),
            array('ProductID' => 'CELCAR38N5','Stock' => '7'),
            array('ProductID' => 'CELCAR39N5','Stock' => '10'),
            array('ProductID' => 'CELCAR40N5','Stock' => '20'),
            array('ProductID' => 'CELCAR41N5','Stock' => '7'),
            array('ProductID' => 'CELCAR42N5','Stock' => '11'),
            array('ProductID' => 'CELCAR43N5','Stock' => '19'),
            array('ProductID' => 'CELCAR44N5','Stock' => '9'),
            array('ProductID' => 'CELCAR45N5','Stock' => '6'),
            array('ProductID' => 'CELGLO37N5','Stock' => '2'),
            array('ProductID' => 'CELGLO38N5','Stock' => '6'),
            array('ProductID' => 'CELGLO39N5','Stock' => '3'),
            array('ProductID' => 'CELGLO40N5','Stock' => '11'),
            array('ProductID' => 'CELGLO41N5','Stock' => '3'),
            array('ProductID' => 'CELGLO43N5','Stock' => '9'),
            array('ProductID' => 'CELGLO44N5','Stock' => '6'),
            array('ProductID' => 'CELGLO45N5','Stock' => '4'),
            array('ProductID' => 'CELGOF37N5','Stock' => '2'),
            array('ProductID' => 'CELGOF38N5','Stock' => '2'),
            array('ProductID' => 'CELGOF39N5','Stock' => '1'),
            array('ProductID' => 'CELGOF40N5','Stock' => '3'),
            array('ProductID' => 'CELGOF41N5','Stock' => '9'),
            array('ProductID' => 'CELGOF42N5','Stock' => '3'),
            array('ProductID' => 'CELGOF43N5','Stock' => '7'),
            array('ProductID' => 'CELGOF44N5','Stock' => '4'),
            array('ProductID' => 'CELGOF45N5','Stock' => '2'),
            array('ProductID' => 'CELSIL37N5','Stock' => '3'),
            array('ProductID' => 'CELSIL38N5','Stock' => '1'),
            array('ProductID' => 'CELSIL42N5','Stock' => '8'),
            array('ProductID' => 'CELSIL43N5','Stock' => '2'),
            array('ProductID' => 'CELSIL44N5','Stock' => '7'),
            array('ProductID' => 'CELSIL45N5','Stock' => '5'),
            array('ProductID' => 'CHAGLO10N5','Stock' => '1'),
            array('ProductID' => 'CHAGLO11N5','Stock' => '1'),
            array('ProductID' => 'CHAGLO12N5','Stock' => '1'),
            array('ProductID' => 'CHAGLO5N5','Stock' => '2'),
            array('ProductID' => 'CHAGLO8N5','Stock' => '4'),
            array('ProductID' => 'CHASIL11N6','Stock' => '8'),
            array('ProductID' => 'CHASIL12N6','Stock' => '3'),
            array('ProductID' => 'CHASIL5N6','Stock' => '1'),
            array('ProductID' => 'DMIBLK10','Stock' => '13'),
            array('ProductID' => 'DMIBLK11','Stock' => '4'),
            array('ProductID' => 'DMIBLK12','Stock' => '4'),
            array('ProductID' => 'DMIBLK6','Stock' => '2'),
            array('ProductID' => 'DMIBLK7','Stock' => '9'),
            array('ProductID' => 'DMIBLK8','Stock' => '9'),
            array('ProductID' => 'DMIBLK9','Stock' => '9'),
            array('ProductID' => 'DMIWHI10','Stock' => '10'),
            array('ProductID' => 'DMIWHI11','Stock' => '3'),
            array('ProductID' => 'DMIWHI12','Stock' => '2'),
            array('ProductID' => 'DMIWHI6','Stock' => '1'),
            array('ProductID' => 'DMIWHI7','Stock' => '4'),
            array('ProductID' => 'DMIWHI8','Stock' => '10'),
            array('ProductID' => 'DMIWHI9','Stock' => '1'),
            array('ProductID' => 'FLOGLO10N6','Stock' => '12'),
            array('ProductID' => 'FLOGLO11N6','Stock' => '9'),
            array('ProductID' => 'FLOGLO12N6','Stock' => '7'),
            array('ProductID' => 'FLOGLO5N6','Stock' => '4'),
            array('ProductID' => 'GAZAUR35N4','Stock' => '2'),
            array('ProductID' => 'GAZAUR36N4','Stock' => '1'),
            array('ProductID' => 'GAZAUR37N4','Stock' => '2'),
            array('ProductID' => 'GAZECL37N4','Stock' => '2'),
            array('ProductID' => 'GAZECL38N4','Stock' => '3'),
            array('ProductID' => 'GAZECL39N4','Stock' => '1'),
            array('ProductID' => 'GAZECL40N4','Stock' => '2'),
            array('ProductID' => 'GAZECL41N4','Stock' => '1'),
            array('ProductID' => 'GAZGLO36N4','Stock' => '2'),
            array('ProductID' => 'GAZGLO37N4','Stock' => '40'),
            array('ProductID' => 'GAZGLO38N4','Stock' => '44'),
            array('ProductID' => 'GAZGLO39N4','Stock' => '15'),
            array('ProductID' => 'GAZGLO41N4','Stock' => '16'),
            array('ProductID' => 'GAZGLO43N4','Stock' => '3'),
            array('ProductID' => 'GAZLUN37N4','Stock' => '2'),
            array('ProductID' => 'GAZLUN38N4','Stock' => '1'),
            array('ProductID' => 'GAZLUN41N4','Stock' => '2'),
            array('ProductID' => 'GAZSOL37N4','Stock' => '1'),
            array('ProductID' => 'GAZSOL38N4','Stock' => '1'),
            array('ProductID' => 'GAZSOL39N4','Stock' => '1'),
            array('ProductID' => 'GAZSOL40N4','Stock' => '2'),
            array('ProductID' => 'GAZSOL41N4','Stock' => '1'),
            array('ProductID' => 'GGABLK10','Stock' => '8'),
            array('ProductID' => 'GGABLK11','Stock' => '2'),
            array('ProductID' => 'GGABLK12','Stock' => '2'),
            array('ProductID' => 'GGABLK6','Stock' => '2'),
            array('ProductID' => 'GGABLK7','Stock' => '9'),
            array('ProductID' => 'GGABLK8','Stock' => '9'),
            array('ProductID' => 'GGABLK9','Stock' => '9'),
            array('ProductID' => 'GGACAM12','Stock' => '1'),
            array('ProductID' => 'GGAWHI12','Stock' => '1'),
            array('ProductID' => 'JEHCAR11N4','Stock' => '10'),
            array('ProductID' => 'JEHCAR37N4','Stock' => '2'),
            array('ProductID' => 'JEHCAR38N4','Stock' => '4'),
            array('ProductID' => 'JEHCAR39N4','Stock' => '3'),
            array('ProductID' => 'JEHCAR41N4','Stock' => '3'),
            array('ProductID' => 'JEHCAR43N4','Stock' => '6'),
            array('ProductID' => 'JEHCAR45N4','Stock' => '1'),
            array('ProductID' => 'JEHCAR5N4','Stock' => '2'),
            array('ProductID' => 'JEHCAR6N4','Stock' => '1'),
            array('ProductID' => 'JEHCOC10N4','Stock' => '5'),
            array('ProductID' => 'JEHCOC11N4','Stock' => '15'),
            array('ProductID' => 'JEHCOC12N4','Stock' => '1'),
            array('ProductID' => 'JEHCOC5N4','Stock' => '5'),
            array('ProductID' => 'JEHCOC6N4','Stock' => '15'),
            array('ProductID' => 'JEHCOC7N4','Stock' => '1'),
            array('ProductID' => 'JEHCRE38N4','Stock' => '3'),
            array('ProductID' => 'JEHCRE41N4','Stock' => '14'),
            array('ProductID' => 'JEHCRE43N4','Stock' => '7'),
            array('ProductID' => 'JEHCRE44N4','Stock' => '2'),
            array('ProductID' => 'JEHCRE45N4','Stock' => '2'),
            array('ProductID' => 'JEHCRE5N4','Stock' => '6'),
            array('ProductID' => 'JEHCRE6N4','Stock' => '1'),
            array('ProductID' => 'JEHGOF11N4','Stock' => '4'),
            array('ProductID' => 'JEHGOF12N4','Stock' => '2'),
            array('ProductID' => 'JEHGOF5N4','Stock' => '1'),
            array('ProductID' => 'JEHGOF6N4','Stock' => '2'),
            array('ProductID' => 'JEHGOF9N4','Stock' => '4'),
            array('ProductID' => 'JEHSIL10N4','Stock' => '12'),
            array('ProductID' => 'JEHSIL11N4','Stock' => '35'),
            array('ProductID' => 'JEHSIL12N4','Stock' => '7'),
            array('ProductID' => 'JEHSIL5N4','Stock' => '2'),
            array('ProductID' => 'JEHSIL6N4','Stock' => '16'),
            array('ProductID' => 'JEHSIL7N4','Stock' => '19'),
            array('ProductID' => 'JEHSIL8N4','Stock' => '7'),
            array('ProductID' => 'JEHWHI12N4','Stock' => '1'),
            array('ProductID' => 'JEHWHI5N4','Stock' => '1'),
            array('ProductID' => 'JEHWHI6N4','Stock' => '1'),
            array('ProductID' => 'JEHWHI9N4','Stock' => '1'),
            array('ProductID' => 'JLABLK5N4','Stock' => '1'),
            array('ProductID' => 'JLABLK7N4','Stock' => '1'),
            array('ProductID' => 'JLACAR11N4','Stock' => '1'),
            array('ProductID' => 'JLAGOL5N4','Stock' => '1'),
            array('ProductID' => 'JLALMA11N4','Stock' => '4'),
            array('ProductID' => 'JLALMA12N4','Stock' => '1'),
            array('ProductID' => 'JLALMA5N4','Stock' => '1'),
            array('ProductID' => 'JLASIL11N4','Stock' => '1'),
            array('ProductID' => 'JLASIL12N4','Stock' => '1'),
            array('ProductID' => 'JLASIL5N4','Stock' => '1'),
            array('ProductID' => 'JLASIL7N4','Stock' => '1'),
            array('ProductID' => 'JLAWHI11N4','Stock' => '1'),
            array('ProductID' => 'JLAWHI12N4','Stock' => '1'),
            array('ProductID' => 'JLAWHI5N4','Stock' => '1'),
            array('ProductID' => 'JOAGLO11N6','Stock' => '3'),
            array('ProductID' => 'JOAGLO12N6','Stock' => '1'),
            array('ProductID' => 'JOAGLO9N6','Stock' => '1'),
            array('ProductID' => 'JOYBLK5','Stock' => '1'),
            array('ProductID' => 'JOYBLK8','Stock' => '6'),
            array('ProductID' => 'JOYBLK9','Stock' => '1'),
            array('ProductID' => 'JOYTIG5','Stock' => '1'),
            array('ProductID' => 'JOYTIG6','Stock' => '1'),
            array('ProductID' => 'JOYTIG8','Stock' => '1'),
            array('ProductID' => 'JOYWHI10','Stock' => '11'),
            array('ProductID' => 'JOYWHI6','Stock' => '2'),
            array('ProductID' => 'JOYWHI7','Stock' => '11'),
            array('ProductID' => 'JOYWHI8','Stock' => '11'),
            array('ProductID' => 'JOYWHI9','Stock' => '11'),
            array('ProductID' => 'KV2GLO10N5','Stock' => '5'),
            array('ProductID' => 'KV2GLO10N6','Stock' => '11'),
            array('ProductID' => 'KV2GLO11N5','Stock' => '4'),
            array('ProductID' => 'KV2GLO11N6','Stock' => '10'),
            array('ProductID' => 'KV2GLO12N5','Stock' => '1'),
            array('ProductID' => 'KV2GLO12N6','Stock' => '6'),
            array('ProductID' => 'KV2GLO5N5','Stock' => '2'),
            array('ProductID' => 'KV2GLO5N6','Stock' => '1'),
            array('ProductID' => 'KV2GLO6N5','Stock' => '4'),
            array('ProductID' => 'KV2GLO6N6','Stock' => '3'),
            array('ProductID' => 'KV2GLO7N5','Stock' => '6'),
            array('ProductID' => 'KV2GLO7N6','Stock' => '10'),
            array('ProductID' => 'KV2GLO8N5','Stock' => '12'),
            array('ProductID' => 'KV2GLO9N5','Stock' => '6'),
            array('ProductID' => 'KV2GLO9N6','Stock' => '4'),
            array('ProductID' => 'KV2MAT10N6','Stock' => '8'),
            array('ProductID' => 'KV2MAT11N6','Stock' => '1'),
            array('ProductID' => 'KV2MAT12N6','Stock' => '1'),
            array('ProductID' => 'KV2MAT5N6','Stock' => '1'),
            array('ProductID' => 'KV2MAT6N6','Stock' => '11'),
            array('ProductID' => 'KV2MAT7N6','Stock' => '9'),
            array('ProductID' => 'KV2MAT8N6','Stock' => '1'),
            array('ProductID' => 'KYLCAR10N5','Stock' => '3'),
            array('ProductID' => 'KYLCAR11N5','Stock' => '11'),
            array('ProductID' => 'KYLCAR12N5','Stock' => '10'),
            array('ProductID' => 'KYLCAR5N5','Stock' => '8'),
            array('ProductID' => 'KYLCAR9N5','Stock' => '5'),
            array('ProductID' => 'KYLGLO10N6','Stock' => '1'),
            array('ProductID' => 'KYLGLO11N5','Stock' => '1'),
            array('ProductID' => 'KYLGLO11N6','Stock' => '6'),
            array('ProductID' => 'KYLGLO12N5','Stock' => '3'),
            array('ProductID' => 'KYLGLO12N6','Stock' => '9'),
            array('ProductID' => 'KYLGLO5N6','Stock' => '4'),
            array('ProductID' => 'KYLGLO6N6','Stock' => '10'),
            array('ProductID' => 'KYLGLO7N6','Stock' => '3'),
            array('ProductID' => 'KYLGLO8N6','Stock' => '14'),
            array('ProductID' => 'KYLGOF11N5','Stock' => '1'),
            array('ProductID' => 'KYLGOF12N5','Stock' => '1'),
            array('ProductID' => 'KYLGOF5N5','Stock' => '1'),
            array('ProductID' => 'KYLGOF5N6','Stock' => '1'),
            array('ProductID' => 'KYLGOF6N5','Stock' => '1'),
            array('ProductID' => 'KYLGOF6N6','Stock' => '1'),
            array('ProductID' => 'KYLGOF7N6','Stock' => '1'),
            array('ProductID' => 'KYLMAT11N6','Stock' => '3'),
            array('ProductID' => 'KYLMAT12N6','Stock' => '6'),
            array('ProductID' => 'KYLMAT7N6','Stock' => '1'),
            array('ProductID' => 'KYLMAT8N6','Stock' => '1'),
            array('ProductID' => 'KYLSIL11N5','Stock' => '1'),
            array('ProductID' => 'KYLSIL11N6','Stock' => '1'),
            array('ProductID' => 'KYLSIL12N5','Stock' => '1'),
            array('ProductID' => 'KYLSIL5N6','Stock' => '1'),
            array('ProductID' => 'LUIPOW10N6','Stock' => '1'),
            array('ProductID' => 'MARGLO10N5','Stock' => '1'),
            array('ProductID' => 'MARGLO10N6','Stock' => '2'),
            array('ProductID' => 'MARGLO11N5','Stock' => '4'),
            array('ProductID' => 'MARGLO11N6','Stock' => '3'),
            array('ProductID' => 'MARGLO12N5','Stock' => '1'),
            array('ProductID' => 'MARGLO12N6','Stock' => '4'),
            array('ProductID' => 'MARGLO5N5','Stock' => '1'),
            array('ProductID' => 'MARGLO5N6','Stock' => '1'),
            array('ProductID' => 'MARGLO6N5','Stock' => '4'),
            array('ProductID' => 'MARGLO7N5','Stock' => '1'),
            array('ProductID' => 'MARGLO7N6','Stock' => '4'),
            array('ProductID' => 'MARGLO8N5','Stock' => '1'),
            array('ProductID' => 'MARGLO9N5','Stock' => '6'),
            array('ProductID' => 'MARMAT11N6','Stock' => '1'),
            array('ProductID' => 'MARMAT6N6','Stock' => '1'),
            array('ProductID' => 'MAUCAR35N4','Stock' => '1'),
            array('ProductID' => 'MAUCAR36N4','Stock' => '1'),
            array('ProductID' => 'MAUCAR38N4','Stock' => '1'),
            array('ProductID' => 'MAUCAR39N4','Stock' => '2'),
            array('ProductID' => 'MAUCAR40N4','Stock' => '1'),
            array('ProductID' => 'MAUCAR41N4','Stock' => '4'),
            array('ProductID' => 'MAUCAR43N4','Stock' => '1'),
            array('ProductID' => 'MAUCAR44N4','Stock' => '4'),
            array('ProductID' => 'MAUCAR45N4','Stock' => '3'),
            array('ProductID' => 'MAUCOC35N4','Stock' => '1'),
            array('ProductID' => 'MAUCOC36N4','Stock' => '1'),
            array('ProductID' => 'MAUCOC37N4','Stock' => '3'),
            array('ProductID' => 'MAUCOC38N4','Stock' => '2'),
            array('ProductID' => 'MAUCOC40N4','Stock' => '4'),
            array('ProductID' => 'MAUCOC41N4','Stock' => '5'),
            array('ProductID' => 'MAUCOC43N4','Stock' => '3'),
            array('ProductID' => 'MAUCOC44N4','Stock' => '1'),
            array('ProductID' => 'MAUCOC45N4','Stock' => '3'),
            array('ProductID' => 'MAUGLO35N4','Stock' => '2'),
            array('ProductID' => 'MAUGLO36N4','Stock' => '1'),
            array('ProductID' => 'MAUGLO37N4','Stock' => '1'),
            array('ProductID' => 'MAUGLO38N4','Stock' => '1'),
            array('ProductID' => 'MAUGLO43N4','Stock' => '4'),
            array('ProductID' => 'MAUGLO44N4','Stock' => '6'),
            array('ProductID' => 'MAUGLO45N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF35N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF36N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF37N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF38N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF40N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF41N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF42N4','Stock' => '1'),
            array('ProductID' => 'MAUGOF43N4','Stock' => '9'),
            array('ProductID' => 'MAUGOF44N4','Stock' => '5'),
            array('ProductID' => 'MAUGOF45N4','Stock' => '5'),
            array('ProductID' => 'MAUSIL35N4','Stock' => '3'),
            array('ProductID' => 'MAUSIL37N4','Stock' => '2'),
            array('ProductID' => 'MAUSIL38N4','Stock' => '2'),
            array('ProductID' => 'MAUSIL39N4','Stock' => '1'),
            array('ProductID' => 'MAUSIL41N4','Stock' => '1'),
            array('ProductID' => 'MAUSIL43N4','Stock' => '1'),
            array('ProductID' => 'MAUSIL44N4','Stock' => '6'),
            array('ProductID' => 'MAUSIL45N4','Stock' => '3'),
            array('ProductID' => 'MAXCAR10N5','Stock' => '1'),
            array('ProductID' => 'MAXCAR10N6','Stock' => '1'),
            array('ProductID' => 'MAXCAR11N5','Stock' => '1'),
            array('ProductID' => 'MAXCAR11N6','Stock' => '1'),
            array('ProductID' => 'MAXCAR12N6','Stock' => '5'),
            array('ProductID' => 'MAXCAR5N6','Stock' => '4'),
            array('ProductID' => 'MAXCAR6N6','Stock' => '3'),
            array('ProductID' => 'MAXCAR7N6','Stock' => '1'),
            array('ProductID' => 'MAXGLO10N5','Stock' => '5'),
            array('ProductID' => 'MAXGLO10N6','Stock' => '28'),
            array('ProductID' => 'MAXGLO11N5','Stock' => '11'),
            array('ProductID' => 'MAXGLO11N6','Stock' => '18'),
            array('ProductID' => 'MAXGLO12N5','Stock' => '12'),
            array('ProductID' => 'MAXGLO12N6','Stock' => '15'),
            array('ProductID' => 'MAXGLO5N5','Stock' => '7'),
            array('ProductID' => 'MAXGLO5N6','Stock' => '3'),
            array('ProductID' => 'MAXGLO6N5','Stock' => '5'),
            array('ProductID' => 'MAXGLO6N6','Stock' => '14'),
            array('ProductID' => 'MAXGLO7N5','Stock' => '7'),
            array('ProductID' => 'MAXGLO7N6','Stock' => '23'),
            array('ProductID' => 'MAXGLO8N5','Stock' => '10'),
            array('ProductID' => 'MAXGLO8N6','Stock' => '31'),
            array('ProductID' => 'MAXGLO9N5','Stock' => '18'),
            array('ProductID' => 'MAXGLO9N6','Stock' => '28'),
            array('ProductID' => 'MAXGOF10N6','Stock' => '4'),
            array('ProductID' => 'MAXGOF11N6','Stock' => '14'),
            array('ProductID' => 'MAXGOF12N6','Stock' => '8'),
            array('ProductID' => 'MAXGOF5N5','Stock' => '1'),
            array('ProductID' => 'MAXGOF5N6','Stock' => '7'),
            array('ProductID' => 'MAXGOF6N6','Stock' => '7'),
            array('ProductID' => 'MAXGOF9N6','Stock' => '2'),
            array('ProductID' => 'MAXMAT10N5','Stock' => '3'),
            array('ProductID' => 'MAXMAT10N6','Stock' => '3'),
            array('ProductID' => 'MAXMAT11N5','Stock' => '1'),
            array('ProductID' => 'MAXMAT12N5','Stock' => '1'),
            array('ProductID' => 'MAXMAT5N6','Stock' => '1'),
            array('ProductID' => 'MAXMAT6N5','Stock' => '7'),
            array('ProductID' => 'MAXMAT6N6','Stock' => '7'),
            array('ProductID' => 'MAXMAT7N5','Stock' => '7'),
            array('ProductID' => 'MAXMAT7N6','Stock' => '8'),
            array('ProductID' => 'MAXMAT8N5','Stock' => '7'),
            array('ProductID' => 'MAXMAT8N6','Stock' => '2'),
            array('ProductID' => 'MAXMAT9N6','Stock' => '1'),
            array('ProductID' => 'MAXSIL10N5','Stock' => '3'),
            array('ProductID' => 'MAXSIL11N5','Stock' => '6'),
            array('ProductID' => 'MAXSIL11N6','Stock' => '1'),
            array('ProductID' => 'MAXSIL12N5','Stock' => '7'),
            array('ProductID' => 'MAXSIL5N5','Stock' => '2'),
            array('ProductID' => 'MAXSIL5N6','Stock' => '1'),
            array('ProductID' => 'MAXSIL6N5','Stock' => '1'),
            array('ProductID' => 'MEGCAR11N5','Stock' => '8'),
            array('ProductID' => 'MEGCAR12N5','Stock' => '2'),
            array('ProductID' => 'MEGCAR7N5','Stock' => '1'),
            array('ProductID' => 'MEGGLO10N5','Stock' => '3'),
            array('ProductID' => 'MEGGLO10N6','Stock' => '12'),
            array('ProductID' => 'MEGGLO11N5','Stock' => '5'),
            array('ProductID' => 'MEGGLO11N6','Stock' => '1'),
            array('ProductID' => 'MEGGLO12N5','Stock' => '2'),
            array('ProductID' => 'MEGGLO12N6','Stock' => '2'),
            array('ProductID' => 'MEGGLO5N5','Stock' => '1'),
            array('ProductID' => 'MEGGLO5N6','Stock' => '3'),
            array('ProductID' => 'MEGGLO6N5','Stock' => '1'),
            array('ProductID' => 'MEGGLO6N6','Stock' => '2'),
            array('ProductID' => 'MEGGLO7N5','Stock' => '1'),
            array('ProductID' => 'MEGGLO8N6','Stock' => '5'),
            array('ProductID' => 'MEGGLO9N5','Stock' => '4'),
            array('ProductID' => 'MEGGLO9N6','Stock' => '3'),
            array('ProductID' => 'MEGMAT10N5','Stock' => '1'),
            array('ProductID' => 'MEGMAT10N6','Stock' => '4'),
            array('ProductID' => 'MEGMAT11N6','Stock' => '7'),
            array('ProductID' => 'MEGMAT12N5','Stock' => '1'),
            array('ProductID' => 'MEGMAT12N6','Stock' => '4'),
            array('ProductID' => 'MEGMAT5N6','Stock' => '2'),
            array('ProductID' => 'MEGMAT6N5','Stock' => '1'),
            array('ProductID' => 'MEGMAT7N5','Stock' => '1'),
            array('ProductID' => 'MEGMAT8N5','Stock' => '1'),
            array('ProductID' => 'MMDBLK37N4','Stock' => '2'),
            array('ProductID' => 'MMDBLK38N4','Stock' => '8'),
            array('ProductID' => 'MMDBLK39N4','Stock' => '15'),
            array('ProductID' => 'MMDBLK40N4','Stock' => '24'),
            array('ProductID' => 'MMDBLK41N4','Stock' => '15'),
            array('ProductID' => 'MMDBLK43N4','Stock' => '8'),
            array('ProductID' => 'MMDBLK44N4','Stock' => '4'),
            array('ProductID' => 'MMDBLK45N4','Stock' => '2'),
            array('ProductID' => 'MMDCAR37N4','Stock' => '2'),
            array('ProductID' => 'MMDCAR38N4','Stock' => '4'),
            array('ProductID' => 'MMDCAR39N4','Stock' => '14'),
            array('ProductID' => 'MMDCAR40N4','Stock' => '13'),
            array('ProductID' => 'MMDCAR41N4','Stock' => '14'),
            array('ProductID' => 'MMDCAR42N4','Stock' => '9'),
            array('ProductID' => 'MMDCAR43N4','Stock' => '9'),
            array('ProductID' => 'MMDCAR44N4','Stock' => '4'),
            array('ProductID' => 'MMDCAR45N4','Stock' => '1'),
            array('ProductID' => 'MMDGLO37N4','Stock' => '2'),
            array('ProductID' => 'MMDGLO38N4','Stock' => '1'),
            array('ProductID' => 'MMDGLO39N4','Stock' => '15'),
            array('ProductID' => 'MMDGLO40N4','Stock' => '16'),
            array('ProductID' => 'MMDGLO41N4','Stock' => '14'),
            array('ProductID' => 'MMDGLO42N4','Stock' => '8'),
            array('ProductID' => 'MMDGLO43N4','Stock' => '1'),
            array('ProductID' => 'MMDGLO44N4','Stock' => '3'),
            array('ProductID' => 'MMDGLO45N4','Stock' => '1'),
            array('ProductID' => 'MMDSIL37N4','Stock' => '1'),
            array('ProductID' => 'MMDSIL38N4','Stock' => '4'),
            array('ProductID' => 'MMDSIL39N4','Stock' => '9'),
            array('ProductID' => 'MMDSIL40N4','Stock' => '1'),
            array('ProductID' => 'MMDSIL41N4','Stock' => '5'),
            array('ProductID' => 'MMDSIL42N4','Stock' => '8'),
            array('ProductID' => 'MMDSIL43N4','Stock' => '7'),
            array('ProductID' => 'MMDSIL44N4','Stock' => '6'),
            array('ProductID' => 'MMDSIL45N4','Stock' => '1'),
            array('ProductID' => 'NICGLO37N6','Stock' => '1'),
            array('ProductID' => 'PIACAR10N5','Stock' => '1'),
            array('ProductID' => 'PIACAR11N5','Stock' => '3'),
            array('ProductID' => 'PIACAR11N6','Stock' => '2'),
            array('ProductID' => 'PIACAR12N5','Stock' => '1'),
            array('ProductID' => 'PIACAR5N5','Stock' => '1'),
            array('ProductID' => 'PIACAR5N6','Stock' => '1'),
            array('ProductID' => 'PIACAR7N6','Stock' => '1'),
            array('ProductID' => 'PIACAR9N5','Stock' => '1'),
            array('ProductID' => 'PIAGLO11N6','Stock' => '10'),
            array('ProductID' => 'PIAGLO12N6','Stock' => '3'),
            array('ProductID' => 'PIAGOF11N5','Stock' => '1'),
            array('ProductID' => 'PIAGOF12N5','Stock' => '1'),
            array('ProductID' => 'PIAGOF12N6','Stock' => '1'),
            array('ProductID' => 'PIAGOF5N6','Stock' => '1'),
            array('ProductID' => 'PIAMAT11N6','Stock' => '4'),
            array('ProductID' => 'PIASIL11N5','Stock' => '1'),
            array('ProductID' => 'PIASIL12N6','Stock' => '1'),
            array('ProductID' => 'PIASIL5N6','Stock' => '1'),
            array('ProductID' => 'RABBLK10N4','Stock' => '8'),
            array('ProductID' => 'RABBLK11N4','Stock' => '10'),
            array('ProductID' => 'RABBLK5N4','Stock' => '1'),
            array('ProductID' => 'RABBLK6N4','Stock' => '8'),
            array('ProductID' => 'RABBLK7N4','Stock' => '7'),
            array('ProductID' => 'RABBLK8N4','Stock' => '3'),
            array('ProductID' => 'RABCAR11N4','Stock' => '1'),
            array('ProductID' => 'RABCAR5N4','Stock' => '1'),
            array('ProductID' => 'RABCAR6N4','Stock' => '1'),
            array('ProductID' => 'RABGOF37N4','Stock' => '2'),
            array('ProductID' => 'RABGOF38N4','Stock' => '4'),
            array('ProductID' => 'RABGOF39N4','Stock' => '6'),
            array('ProductID' => 'RABGOF40N4','Stock' => '6'),
            array('ProductID' => 'RABGOF41N4','Stock' => '6'),
            array('ProductID' => 'RABGOF43N4','Stock' => '6'),
            array('ProductID' => 'RABGOF44N4','Stock' => '2'),
            array('ProductID' => 'RABGOF45N4','Stock' => '2'),
            array('ProductID' => 'RABLMA10N4','Stock' => '11'),
            array('ProductID' => 'RABLMA11N4','Stock' => '7'),
            array('ProductID' => 'RABLMA12N4','Stock' => '1'),
            array('ProductID' => 'RABLMA40N4','Stock' => '14'),
            array('ProductID' => 'RABLMA5N4','Stock' => '8'),
            array('ProductID' => 'RABLMA6N4','Stock' => '12'),
            array('ProductID' => 'RABLMA7N4','Stock' => '13'),
            array('ProductID' => 'RABLMA8N4','Stock' => '7'),
            array('ProductID' => 'RABLMA9N4','Stock' => '13'),
            array('ProductID' => 'RABVGO10N4','Stock' => '3'),
            array('ProductID' => 'RABVGO11N4','Stock' => '4'),
            array('ProductID' => 'RABVGO12N4','Stock' => '2'),
            array('ProductID' => 'RABVGO5N4','Stock' => '2'),
            array('ProductID' => 'RABVGO7N4','Stock' => '4'),
            array('ProductID' => 'RABVGO8N4','Stock' => '2'),
            array('ProductID' => 'RABVGO9N4','Stock' => '1'),
            array('ProductID' => 'RABWHI10N4','Stock' => '5'),
            array('ProductID' => 'RABWHI11N4','Stock' => '1'),
            array('ProductID' => 'RABWHI12N4','Stock' => '2'),
            array('ProductID' => 'RABWHI5N4','Stock' => '1'),
            array('ProductID' => 'RABWHI6N4','Stock' => '2'),
            array('ProductID' => 'RABWHI7N4','Stock' => '5'),
            array('ProductID' => 'RABWHI8N4','Stock' => '12'),
            array('ProductID' => 'RABWHI9N4','Stock' => '11'),
            array('ProductID' => 'RACCAR10N5','Stock' => '1'),
            array('ProductID' => 'RACCAR11N5','Stock' => '1'),
            array('ProductID' => 'RACCAR5N5','Stock' => '1'),
            array('ProductID' => 'RACCAR6N5','Stock' => '1'),
            array('ProductID' => 'RACCAR9N5','Stock' => '1'),
            array('ProductID' => 'RACGLO10N5','Stock' => '16'),
            array('ProductID' => 'RACGLO11N5','Stock' => '4'),
            array('ProductID' => 'RACGLO11N6','Stock' => '8'),
            array('ProductID' => 'RACGLO12N5','Stock' => '3'),
            array('ProductID' => 'RACGLO12N6','Stock' => '15'),
            array('ProductID' => 'RACGLO5N5','Stock' => '1'),
            array('ProductID' => 'RACGLO5N6','Stock' => '2'),
            array('ProductID' => 'RACGLO6N5','Stock' => '12'),
            array('ProductID' => 'RACGLO6N6','Stock' => '17'),
            array('ProductID' => 'RACGLO7N5','Stock' => '7'),
            array('ProductID' => 'RACGLO7N6','Stock' => '17'),
            array('ProductID' => 'RACGLO8N5','Stock' => '23'),
            array('ProductID' => 'RACGLO8N6','Stock' => '17'),
            array('ProductID' => 'RACGLO9N5','Stock' => '10'),
            array('ProductID' => 'RACGLO9N6','Stock' => '8'),
            array('ProductID' => 'RACGOF10N5','Stock' => '6'),
            array('ProductID' => 'RACGOF11N5','Stock' => '6'),
            array('ProductID' => 'RACGOF12N5','Stock' => '7'),
            array('ProductID' => 'RACGOF5N5','Stock' => '6'),
            array('ProductID' => 'RACGOF6N5','Stock' => '4'),
            array('ProductID' => 'RACGOF9N5','Stock' => '2'),
            array('ProductID' => 'RACMAT10N6','Stock' => '1'),
            array('ProductID' => 'RACMAT11N5','Stock' => '3'),
            array('ProductID' => 'RACMAT11N6','Stock' => '3'),
            array('ProductID' => 'RACMAT12N5','Stock' => '3'),
            array('ProductID' => 'RACMAT12N6','Stock' => '2'),
            array('ProductID' => 'RACSIL10N5','Stock' => '1'),
            array('ProductID' => 'RACSIL11N5','Stock' => '1'),
            array('ProductID' => 'RACSIL12N5','Stock' => '1'),
            array('ProductID' => 'RUFBLK10','Stock' => '3'),
            array('ProductID' => 'RUFBLK11','Stock' => '1'),
            array('ProductID' => 'RUFBLK12','Stock' => '3'),
            array('ProductID' => 'RUFBLK6','Stock' => '1'),
            array('ProductID' => 'RUFBLK8','Stock' => '1'),
            array('ProductID' => 'SAMGLO8N5','Stock' => '8'),
            array('ProductID' => 'SAMGLO9N5','Stock' => '5'),
            array('ProductID' => 'UNOCAM12','Stock' => '1'),
            array('ProductID' => 'UNOCAM6','Stock' => '1'),
            array('ProductID' => 'UNOCAM8','Stock' => '1'),
            array('ProductID' => 'VALBNW12','Stock' => '2'),
            array('ProductID' => 'VENCAR11N6','Stock' => '2'),
            array('ProductID' => 'VENCAR12N6','Stock' => '1'),
            array('ProductID' => 'VENGLO10N6','Stock' => '14'),
            array('ProductID' => 'VENGLO11N6','Stock' => '4'),
            array('ProductID' => 'VENGLO5N6','Stock' => '2'),
            array('ProductID' => 'VENGLO6N6','Stock' => '19'),
            array('ProductID' => 'VENGLO7N6','Stock' => '19'),
            array('ProductID' => 'VENGLO8N6','Stock' => '22'),
            array('ProductID' => 'VENGLO9N6','Stock' => '19'),
            array('ProductID' => 'WALMAR0','Stock' => '4'),
            array('ProductID' => 'WALMAR1','Stock' => '4'),
            array('ProductID' => 'WALMEN0','Stock' => '4'),
            array('ProductID' => 'WALORA0','Stock' => '4'),
            array('ProductID' => 'WALWHI0','Stock' => '4'),
            array('ProductID' => 'WALWHI1','Stock' => '4'),
            array('ProductID' => 'YVEGLO10N5','Stock' => '19'),
            array('ProductID' => 'YVEGLO10N6','Stock' => '19'),
            array('ProductID' => 'YVEGLO11N5','Stock' => '2'),
            array('ProductID' => 'YVEGLO11N6','Stock' => '2'),
            array('ProductID' => 'YVEGLO12N5','Stock' => '2'),
            array('ProductID' => 'YVEGLO12N6','Stock' => '2'),
            array('ProductID' => 'YVEGLO5N5','Stock' => '2'),
            array('ProductID' => 'YVEGLO5N6','Stock' => '2'),
            array('ProductID' => 'YVEGLO6N5','Stock' => '19'),
            array('ProductID' => 'YVEGLO6N6','Stock' => '19'),
            array('ProductID' => 'YVEGLO7N5','Stock' => '24'),
            array('ProductID' => 'YVEGLO7N6','Stock' => '24'),
            array('ProductID' => 'YVEGLO8N5','Stock' => '20'),
            array('ProductID' => 'YVEGLO8N6','Stock' => '28'),
            array('ProductID' => 'YVEGLO9N5','Stock' => '19'),
            array('ProductID' => 'YVEGLO9N6','Stock' => '24')
          );

        foreach($products as $product){
            // dd($product['ProductID']);
            $checkProduct = DB::table('products')->where('product_sku', '=', $product['ProductID'])->first();
            $user_id = Auth::user()->id;
            if($checkProduct){
                DB::table('product_stocks')->insert([
                    'user_id' => $user_id,
                    'product_id' => $checkProduct->id,
                    'barcode_id' => 0,
                    'order_number' => 0,
                    'stocks' => $product['Stock'],
                    'remarks' => 'ADDED FROM ORIGINAL STOCKS IN SYSTEM',
                    'status' => 'INCOMING',
                    'action' => 'ADD'
                ]);
            }
            
        } 
    }


    public function render()
    {
        
        $query = Product::select(
            'products.id', 
            'products.product_sku', 
            'products.model', 'products.color', 
            'products.size', 
            'products.heel_height', 
            'products.category', 
            DB::raw('COALESCE(product_stocks.total_stocks, 0) as product_total_stocks'), 
            DB::raw('COALESCE(outlet_product_stocks.total_stocks, 0) as outlet_product_total_stocks')
        )
        ->where('products.product_sku', 'like', '%'.$this->product_sku_search.'%')
        ->where('products.model', 'like', '%'.$this->model_search.'%')
        ->where('products.color', 'like', '%'.$this->color_search.'%')
        ->where('products.size', 'like', '%'.$this->size_search.'%')
        ->where('products.heel_height', 'like', '%'.$this->heel_search.'%')
        ->where('products.category', 'like', '%'.$this->category_search.'%')
        ->leftJoin(
            DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM product_stocks GROUP BY product_id) as product_stocks'), 'products.id', '=', 'product_stocks.product_id'
        )
        ->leftJoin(
            DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM outlet_product_stocks GROUP BY product_id) as outlet_product_stocks'), 'products.id', '=', 'outlet_product_stocks.product_id'
        )
        ->groupBy(
            'products.id', 
            'products.product_sku', 
            'products.model', 
            'products.color', 
            'products.size', 
            'products.heel_height', 
            'products.category', 
            'product_total_stocks', 
            'outlet_product_total_stocks'
        )
        ->orderBy('products.id', 'asc');

        if ($this->filterProducts == 1) {
            $query->where('product_stocks.total_stocks', '>', 0)->where('product_stocks.total_stocks', '!=', 0);
        }

        if ($this->filterProducts == -1) {
            $query->where('product_stocks.total_stocks', '<', 0)->where('product_stocks.total_stocks', '!=', 0);
        }

        $products = $query->paginate(25);

        return view('livewire.products', [
            'products' => $products
        ]);
    }
}
