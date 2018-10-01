<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main><!-- #main -->

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer><!-- .footer-wrapper -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>
<!--
<?php if(is_active_sidebar('stroke')): ?>


<div class="bot-lines">
	<div class="bot-lines-close">x</div>
	<ul class="swbuttons"></ul>
<?php dynamic_sidebar( 'stroke' ); ?>
</div>
-->
<style>
.bot-lines { height: 33px; position: fixed; bottom: 0; left: 0; padding: 5px 0; width: 100%; background: rgba(255,255,255,0.9); z-index: 100; color: #000; overflow: hidden;}
.bot-lines p { margin: 0; }
.bot-lines-close { z-index: 9999; cursor: pointer; position: absolute; top: 0; left: 0; padding: 5px 4px 4px 6px; background: rgba(255,255,255,0.9); width: 7px; height: 8px;  height: 33px; width: 33px;}
.bot-lines .lineone { opacity: 0; position: absolute; white-space: nowrap; overflow: hidden; }
.swbuttons { margin: 0; background: rgba(255,255,255,0.9); padding: 12px 0 12px 5px; position: absolute; left: 23px; top: 0; z-index: 9999; }
.swbuttons li { cursor: pointer; float: left; display: block; background: #959595; width: 12px; height: 12px; border-radius: 6px; margin: 0 4px 0 0; }
.swbuttons li.active { background: #ff9e05; } 
.wppp-select {margin-top: 5px !important; padding-right: 25px; border: 2px #7A9D3E solid;}
.orderby {border: 2px #7A9D3E solid;}
@media (max-width: 860px){.woocommerce-ordering {float: left;}}
@media (min-width: 860px){.prdctfltr_filter_title{display:none !important;}}
</style>

<script>
var speed=16e3,tout=5e3,current=0,timeoutid=-1,ilength=new Array,icount,ix=new Array;jQuery(document).ready(function(){function e(){icount=jQuery(".lineone").length;var e;jQuery(".lineone").each(function(){e=(jQuery(window).width()-jQuery(this).width())/2,ilength.push(jQuery(this).width()),e<=0?ix.push(10):ix.push(e)}),jQuery(".lineone").css("left",jQuery(window).width()),jQuery(".lineone").css("opacity","1")}function n(e){jQuery(".swbuttons li").removeClass("active"),jQuery(".swbuttons li").eq(e).addClass("active"),jQuery(".lineone").eq(e).animate({left:ix[e]},speed,"linear",function(){timeoutid=setTimeout(function(){var t;t=ilength[e]<jQuery(window).width()?speed:Math.round(speed*ilength[e]/jQuery(window).width()),jQuery(".lineone").eq(e).animate({left:-1*ilength[e]},t,"linear",function(){jQuery(".lineone").eq(e).css("left",jQuery(window).width()),++current>=icount&&(current=0),n(current)})},tout)})}jQuery(".lineone").length&&(jQuery(".lineone").each(function(){jQuery(".swbuttons").append("<li></li>")}),jQuery(".swbuttons li").eq(0).addClass("active"),e(),n(current),jQuery(".swbuttons li").click(function(){return jQuery(".lineone").stop(!0,!0),-1!=timeoutid&&clearTimeout(timeoutid),e(),n(jQuery(".swbuttons li").index(jQuery(this))),!1}))});
</script>
<?php  endif; ?>
</body>
</html>

