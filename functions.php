<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */
 
// удаляем описание категории на странице категорий
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
// выводим описание категории под товарами
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 );

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
 
function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'RUB': $currency_symbol = ' Руб'; break;
     }
     return $currency_symbol;
}


    /*register_sidebar(array(
        'name' => 'Бегущая строка',
		'id' => 'stroke',
        'before_widget' => '<div class="lineone">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));*/
	

	register_sidebar( array(
    'name'          => __( 'Правый боковой сайдбар в категории', 'flatsome' ),
    'id'            => 'shop-sidebar2',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title shop-sidebar">',
    'after_title'   => '</span><div class="is-divider small"></div>',
  ) );

  
  
require get_template_directory() . '/inc/init.php';

function flatsome_result_count_and_catalog_ordering_remover() {
remove_action( 'flatsome_category_title_alt', 'woocommerce_result_count', 20);
}
add_action('template_redirect','flatsome_result_count_and_catalog_ordering_remover');

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
//Кнопки с картинками и описанием
add_action('woocommerce_after_single_product_summary', function() {
  echo '<div style="text-align: center;padding-bottom: 20px; font-size: 15px;"> <div class="tooltip1 tooltip1stered"> <img src="https://www.otdelka1.ru/wp-content/uploads/2017/10/dostavka.png"> <p>Бесплатная доставка</p> <div class="tooltip1text">Бесплатная доставка осуществляется при условии заказа от 70000 руб. весом не более 1000 кг. в пределах МКАД. <br> </div> </div> <div class="tooltip1 tooltip1stered"> <img src="https://www.otdelka1.ru/wp-content/uploads/2017/10/vozvrat.png"> <p>Возврат-обмен</p> <div class="tooltip1text">Возврат товаров осуществляется согласно Закону о защите прав потребителей в течении 14 календарных дней с момента оплаты.</div> </div> <div class="tooltip1 tooltip1stered"> <img src="https://www.otdelka1.ru/wp-content/uploads/2017/10/hranenie.png"> <p>Хранение товара</p> <div class="tooltip1text">При необходимости, мы готовы бесплатно хранить Вашу покупку на нашем складе в течении 2-х недель.</div> </div><div class="tooltip1 tooltip1stered"> <img src="https://www.otdelka1.ru/wp-content/uploads/2017/10/bestprice.png"> <p>Лучшая цена</p> <div class="tooltip1text">Мы являемся официальными дилерами всей представленной на сайте продукции. Многие товары продаются с подарками и по минимальной розничной цене. Тем не менее, если где-то Вам предложили более низкую цену, сообщите нам об этом.</div> </div><a href="https://www.otdelka1.ru/o-nas/"><div class="tooltip1 tooltip1stered"> <img src="https://www.otdelka1.ru/wp-content/uploads/2017/10/vsepreim.png"> <p>Все преимущества</p> </div></a> </div>';
}, 1);

 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );   // Удаление вкладки с характеристиками
    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'woo_sop_product_tab' );

function woo_sop_product_tab( $tabs ) {
  
  // Добавление вкладки сопутствующих товаров
  
  $tabs['sop_tab'] = array(
    'title'   => __( 'Сопутствующие товары', 'woocommerce' ),
    'priority'  => 12,
    'callback'  => 'woo_sop_product_tab_content'
  );

  return $tabs;

}

function woo_sop_product_tab_content() {
  
echo do_shortcode('[wcsp_cross_sell] ');
}

add_filter( 'woocommerce_product_tabs', 'woo_rel_product_tab' );

// Добавление вкладки похожих товаров
function woo_rel_product_tab( $tabs ) {
  $tabs['rel_tab'] = array(
    'title'   => __( 'Похожие товары', 'woocommerce' ),
    'priority'  => 50,
    'callback'  => 'woo_rel_product_tab_content'
  );

  return $tabs;

}
function woo_rel_product_tab_content() {

  woocommerce_upsell_display();
}

// Регистрация виджета "Вывод характеристик"
function producAttr_load_widget() {
    register_widget( 'producAttr_widget' );
}
add_action( 'widgets_init', 'producAttr_load_widget' );
 
// Создание виджета
class producAttr_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
'producAttr_widget', 
 
__('Вывод атрибутов товара', 'producAttr_widget_domain'), 
 
// Описание виджета
array( 'description' => __( 'Для страницы товара', 'producAttr_widget_domain' ), ) 
);
}

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
 
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
 
// Code
global $product;
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
 
$has_row    = false;
$attributes = $product->get_attributes();
 
ob_start();
 
?>
<div class="product_attributes">
  <div><h2>Характеристики: </h2></div>    
  <?php foreach ( $attributes as $attribute ) :
 
    if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) 
      continue;

				$values = array();
				if ( $attribute->is_taxonomy() ) {
					$attribute_taxonomy = $attribute->get_taxonomy_object();
					$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
					foreach ( $attribute_values as $attribute_value ) {
						$value_name = esc_html( $attribute_value->name );
						if ( $attribute_taxonomy->attribute_public ) {
							$values[] = '<a class="attribute_link" href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
						} else {
							$values[] = $value_name;
						}
					}
				} else {
					$values = $attribute->get_options();
					foreach ( $values as &$value ) {
						$value = make_clickable( esc_html( $value ) );
					}
				}
 
   // $values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
    $att_val = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
 
    if( empty( $att_val ) )
      continue;
 
    $has_row = true;
    ?>
 
  <div>
    <div class="att_label" style="font-weight: bold; display: inline-block;"><?php echo wc_attribute_label( $attribute['name'] ); ?></div>
    <?php echo ': '; ?>
    <div class="att_value" style="display: inline-block;"><?php echo $att_val; ?></div><!-- .att_value -->
  </div><!-- .col -->
 
  <?php endforeach; ?>
 
</div><!-- .product_attributes -->
<?php
if ( $has_row ) {
  echo ob_get_clean();
} else {
  ob_end_clean();
}
}
         
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Характеристики', 'producAttr_widget_domain' );
}
// producAttr
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
     
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
}
// конец виджета

// редактирование заказа при статусе обработка
add_filter('wc_order_is_editable', 'my_wc_order_is_editable', 10, 2);
function my_wc_order_is_editable($res, $order) {
    if(in_array($order->get_status(), array('processing', 'cancelled'))) {
        return true;
    }
    return $res;
}

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */
 
 
 