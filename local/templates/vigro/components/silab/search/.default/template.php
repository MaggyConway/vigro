<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();


\Bitrix\Main\UI\Extension::load("ui.vue3");

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<!-- <span id="search_toggle"></span> -->

<div id="header__search_app">
     <!--FORM-->
     <form class="header__search" v-on:submit.prevent="submit" :class="{'active': stateForm}">
        <button type="submit"><span class="material-symbols-outlined">search</span></button>
        <input 
                v-model="query" 
                v-on:input="search" 
                type="text" 
                placeholder="Поиск" 
                v-on:focus="stateForm = true"
                v-on:blur="stateForm = false"
            />
        <button v-if="query.length > 0" type="button" 
                v-on:click="close" ><span class="material-symbols-outlined">close</span></button>
    </form>
    <!--/FORM-->

    <!--RESULT-->
    <div class="header__search__result hide" v-bind:class="{show: isResult, 'show-result': products.length > 0}">
        <div class="header__search__container">
            <div class="container">
                <!--LIST-->
                <template v-if="categories.length > 0">
                    <h4 class="header__search__result-title">Категории</h4>
                    <div class="mb-5">
                        <div v-for="(item, index) in categories" v-bind:key="index">
                            <a v-bind:href="item.SECTION_PAGE_URL" class="header__search__result-categoty">
                                {{item.NAME}} <span class="material-symbols-outlined">arrow_forward_ios</span>
                            </a>
                        </div>
                    </div>
                </template>

                <template v-if="products.length > 0">
                    <h4 class="header__search__result-title">Товары</h4>
                    <!--products-->
                    <div class="row">
                        <div v-for="(item, index) in products" v-bind:key="index" class="col-6">
                            <div class="catalog_item">
                                <a v-bind:href="item.DETAIL_PAGE_URL">
                                    <img v-bind:src="item.IMAGE" v-bind:alt="item.NAME">
                                </a>
                                <p class="catalog_item__title">
                                    <a v-bind:href="item.DETAIL_PAGE_URL">{{item.NAME}}</a>
                                    <span class="wish" v-bind:class="{active: item.WISH}" v-bind:data-product-id="item.ID"></span>
                                </p>
                                <p class="catalog_item__price">{{item.PRICE_FORMAT}} ₽</p>
                            </div>
                        </div>
                    </div>
                    <!--/products-->
                </template>
                <!--ERRORS-->
                <div v-else-if="error.length > 0" style="color: #ff4d4d;">{{error}}</div>
                <!--ERRORS-->
                <!--EMPTY-->
                <div v-else >По вашему запросу ничего не найдено!</div>
                <!--/EMPTY-->
                
                <!--PAGIN-->
                <div class="header__search__pagin mt-5">
                    <div class="row">
                        <div class="col-6">
                            <a v-if="page > 1" href="javascript:void(0);" v-on:click.prevent="prev" class="search-load-more">Предыдущая страница</a>
                        </div>
                        <div class="col-6 text-right">
                            <a v-if="page < pages" href="javascript:void(0);" v-on:click.prevent="next" class="search-load-more">Следующая страница</a>
                        </div>
                    </div>
                </div>
                <!--PAGIN-->
            </div>
            <!--/LIST-->
        </div>
    </div>
    <!--/RESULT-->
</div>
