/**
 * @author chengx nixgnehc@gmail.com
 */
$(document).ready(function(){
    //右侧顶部事件监听
    topBtnListener();
    // 导航栏监听
    navListener();
    // 新建项目
    addProject();

})
function addProject()
{
    $(".add_project>.tabs>a").click(function(){
        var tab = $(this).children();
        if ($(this).index() == 0) {
            if (!$(tab).hasClass('show')){
                $(tab).addClass('show');
                $(this).next().children().removeClass('show');
                $(".unassociated").hide();
                $(".add_new").show('slow');
            }
        } else {
            if (!$(tab).hasClass('show')){
                $(tab).addClass('show');
                $(this).prev().children().removeClass('show');
                $(".add_new").hide();
                $(".unassociated").show('slow');
            }
        }
    });
    $(".add_project>.unassociated>.directory>ul>li>a").click(function(){
        var tab = $(this).parent();
        if ($(tab).index() == 0){
            if (!$(this).hasClass('show')){
                $(this).addClass('show');
                $(tab).next().children().removeClass('show');
            } else {
                if (!$(this).hasClass('show')){
                    $(this).addClass('show');
                    $(this).prev().children().removeClass('show');
                }
            }
        }
    });
}
function navListener()
{
    $(".info_nav>.nav>ul>li>a").toggle(function(){
        $(this).addClass('open');
        $(this).next().show('slow');
    },function(){
        $(this).removeClass('open');
        $(this).next().hide('slow');
    });
}
function topBtnListener()
{
    $("#switch_operate,#top_mail,#system_mail").click(function(){
        if ($(this).attr('id') == 'switch_operate') {
            if ($(".operates").hasClass('hide')) {
                $(".message_area").hide('slow').addClass('hide');
                $(".operates").show('slow').removeClass('hide');
            } else {
                $(".operates").hide('slow').addClass('hide');
            }
        } else if($(this).attr('id') == 'top_mail') {
            if ($(".mail_area").hasClass('hide')) {
                $('.system_area,.operates').hide('slow').addClass('hide');
                $('.mail_area').show('slow').removeClass('hide');
            } else {
                $('.mail_area').hide('slow').addClass('hide');
            }
        } else if($(this).attr('id') == 'system_mail') {
            if ($(".system_area").hasClass('hide')) {
                $('.mail_area,.operates').hide('slow').addClass('hide');
                $('.system_area').show('slow').removeClass('hide');
            } else {
                $('.system_area').hide('slow').addClass('hide');
            }
        }
    });
    $(".mail_area,.system_area,.operates").mouseleave(function(){
        if ($(this).hasClass('mail_area')) {
            $("#top_mail").click();
        } else if ($(this).hasClass('system_area')) {
            $("#system_mail").click();
        } else if ($(this).hasClass('operates')) {
            $("#switch_operate").click();
        }
    });
}