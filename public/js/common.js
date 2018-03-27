/**
 * Created by MenNguyen on 3/27/2018.
 */
function show_spinner(){

    jQuery("body").nimbleLoader("show", {
        position             : "fixed",
        loaderClass          : "loading_bar_body",
        debug                : true,
        speed                : 700,
        hasBackground        : true,
        zIndex               : 999999,
        backgroundColor      : "transparent",
        backgroundOpacity    : 0.5
    });

}
function hide_spinner(){
    jQuery("body").nimbleLoader("hide");
}
