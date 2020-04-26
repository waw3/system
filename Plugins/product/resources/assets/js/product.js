$(document).ready(() => {
    BDashboard.loadWidget($('#widget_products_recent').find('.widget-content'), route('products.widget.recent-products'));
});