(function(window) {
    'use strict';

    BX.ready(function() {
        /**
         * Компонент поиска
         */
        BX.Vue3.BitrixVue.createApp({
            data: function() {
                return {
                    isResult: false,
                    stateForm: false,
                    query: '',
                    time: 0,
                    products: [],
                    categories: [],
                    error: '',
                    isPreloader: false,
                    page: 1,
                    pages: -1,
                    lastRunAction: 0,
                };
            },
            watch: {
                stateForm: function(val) {
                    if (val) {
                        $('.header_menu_from_serch').addClass('header_menu_from_serch-none');
                    } else {
                        $('.header_menu_from_serch').removeClass('header_menu_from_serch-none');
                    }

                },
            },
            methods: {
                /**
                 * Ajax request to component
                 * @returns {undefined}
                 */
                runAction: async function() {
                    var v = this;

                    v.clear();
                    v.isPreloader = true;
                    v.isResult = false;

                    let last = ++v.lastRunAction;

                    try {
                        // to ajax bitrix service
                        let response = await BX.ajax.runComponentAction("silab:search", "query", {
                            mode: "class",
                            data: {
                                query: this.query,
                                page: this.page,
                            }
                        });

                        // is last
                        if (last === v.lastRunAction) {
                            v.setResponse(response);
                            v.isPreloader = false;
                            v.isResult = true;
                        }
                    } catch (err) {

                        // is last
                        if (last === v.lastRunAction) {
                            v.error = 'Произошла ошибка попробуйте позже!';
                            v.isPreloader = false;
                        }
                    }
                },
                /**
                 * Set response
                 * @param {type} response
                 * @returns {undefined}
                 */
                setResponse: function(response) {

                    var v = this;

                    if (response.data.result !== undefined) {
                        v.categories = response.data.result.categories;
                        v.products = response.data.result.products;
                        v.pages = response.data.result.pages;
                    } else if (response.data.error[1] !== undefined) {
                        v.error = response.data.error[1];
                    } else {
                        v.error = 'Произошла ошибка на сервер!';
                    }
                },
                /**
                 * Next page 
                 * @returns {undefined}
                 */
                next: function() {
                    if (this.page < this.pages) {
                        this.page++;
                        this.runAction();
                    }
                },
                /**
                 * Prevend page
                 * @returns {undefined}
                 */
                prev: function() {
                    if (this.page > 1) {
                        this.page--;
                        this.runAction();
                    }
                },
                /**
                 * Search 
                 * @returns {undefined}
                 */
                search: function() {
                    var v = this;

                    if (v.query.length < 3)
                        return;

                    var localTime = setTimeout(function() {

                        if (v.time === localTime) {
                            v.runAction(localTime);
                        }

                    }, 600);

                    v.time = localTime;
                },
                /**
                 * Submit 
                 * @returns {undefined}
                 */
                submit: function(event) {
                    this.runAction();
                },
                /**
                 * Clear data
                 * @returns {undefined}
                 */
                clear: function() {
                    var v = this;
                    v.products = [];
                    v.categories = [];
                    v.error = '';
                    v.isPreloader = false;
                    v.isResult = false;
                },
                close: function() {
                    var v = this;
                    v.query = '';
                    v.clear();
                },
            },
            mounted: function() {
                var v = this;

                BX.addCustomEvent('silab_search__on_search-toggle', BX.delegate(function() {
                    v.clear();
                    v.isPreloader = false;
                    v.query = '';
                    v.time = 0;
                    v.lastRunAction = 0;
                }));
            }
        }).mount('#header__search_app');
    });
})(window);