/*
 * jQuery v1.9.1 included
 */
$(document).ready(function() {
  
    if (document.location.href.indexOf('requests/new') != -1) {
        $('body').addClass("e_requests_new");
    }
    if (document.location.href.indexOf('questions/new') != -1) {
        $('body').addClass("e_questions_new");
    }
    if (document.location.href.indexOf('questions') != -1) {
        if ($('.question-body').length > 0) {
            $('main').addClass("questions e_questionsDetail");
        } else {
            $('main').addClass("e_questionsLists");
        }
        $('.question~p').detach().appendTo('.answers');
        $('.question-subscribe').parent('span').detach().insertAfter('.question-share');
        $('.question-unsubscribe').parent('span').detach().insertAfter('.question-share');
        //chagne to button
        var pWrapper =  $('.answers article+p')[0];
        var aElement = $('a',pWrapper)[0];
        if(pWrapper && aElement){
          $(aElement).text($(pWrapper).text());
          $(aElement).attr("role","button");
          $(aElement).addClass('e_postQuestion');
          $(pWrapper).html(aElement);
        }
    }
    if (document.location.href.indexOf('topics') != -1) {
        if ($('.topic-body').length > 0) {
            $('main').addClass("questions e_questionsDetail");
        } else {
            $('main').addClass("e_questionsLists");
        }
    }
    if (document.location.href.indexOf('topics') != -1) {
        $('main').addClass("topics");
    }

    // question fix
    $('.questions > .sub-nav.clearfix, .e_questionsLists > .sub-nav.clearfix').attr('class', 'grid');
    $(".questions > .grid, .e_questionsLists > .grid").wrap("<section id='jumbotron'></section>").wrap("<div class='container'></div>");

    $(".questions > .community-nav, .e_questionsLists > .community-nav").wrap("<section id='questions-nav'></section>").wrap("<div class='container'></div>").wrap("<div class='grid'></div>");

    $('.questions > .clearfix, .e_questionsLists > .clearfix').attr('class', 'grid');
    $(".questions > .grid, .e_questionsLists > .grid").wrap("<section id='questions-content'></section>").wrap("<div class='container'></div>");

    $(".questions > #jumbotron > .container > .grid > .search-small, .e_questionsLists > #jumbotron > .container > .grid > .search-small").attr('class', 'search');
    $(".questions > #jumbotron > .container > .grid > .search, .e_questionsLists > #jumbotron > .container > .grid > .search").wrap("<div class='search-bar'></div>");

    $(".questions #questions-content .main-column .answer-form").appendTo(".questions #questions-content .main-column .answers");
    // wrapped meta + controls with question-footer
    $(".questions #questions-content .question .question-meta, #questions-content .question .question-controls").wrapAll("<div class='question-footer'></div>");
    // moved question footer
    $(".questions #questions-content .question .question-footer").insertAfter("#questions-content .question .question-body");
    // change 'answer' to 'Answer'
    $(".questions #questions-content .answer-list-heading").text(function(index, text) {
        return text.replace("answer", "Answer");
    });
    //change share text
    $('.share-label').text('Share this page');
    // add best answer
    $(".e_questionsLists #questions-content .question .answer .answer-body").prepend("<h4>Best answer:</h4>");
    //http://community.estimote.com/hc/communities/public/questions?filter=trending&locale=en-us no logged
    // move "post a question or idea"
    $(".e_questionsLists #questions-content .community-sub-nav ul").append("<li><a href='/hc/communities/public/questions/new' role='button'>Post a question or idea</a></li>");
    // added "by" in question list
    if($('.question-author a').length){
      $(".e_questionsLists .question-list .question .question-meta .question-author a").prepend("<span> by </span>");
    }else{
      $('span.question-author').prepend('by ');
    }

    // move search result meta under text
    $('.search-result-meta').each(function(k, v) {
        p = v.parentNode;
        $(".search-result-description", p).append(v);
    });
    // search result tweaks
    $('.search-result-meta').contents().filter(function() {
        return this.nodeType != 1;
    }).remove();

    // add ticket DOM change
    $('.e_requests_new main').prepend('<section id="jumbotron"><div class="container"><nav class="grid"><h4 class="community-heading">Community</h4><div class="search-bar"><form accept-charset="UTF-8" action="/hc/en-us/search?community_id=public" class="search" method="get" role="search"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓"></div><input id="query" name="query" placeholder="Search" type="search"></form></div></nav></div></section>');
    $('.e_requests_new main .sub-nav, .e_requests_new main .clearfix').wrap('<div class="container"><div class="grid"></div></div>');

    // social share popups
    $(".share a").click(function(e) {
        e.preventDefault();
        window.open(this.href, "", "height = 500, width = 500");
    });

    // toggle the share dropdown in communities
    $(".share-label").on("click", function(e) {
        e.stopPropagation();
        var isSelected = this.getAttribute("aria-selected") == "true";
        this.setAttribute("aria-selected", !isSelected);
        $(".share-label").not(this).attr("aria-selected", "false");
    });

    $(document).on("click", function() {
        $(".share-label").attr("aria-selected", "false");
    });

    // show form controls when the textarea receives focus
    $(".answer-body textarea").one("focus", function() {
        $(".answer-form-controls").show();
    });

    $(".comment-container textarea").one("focus", function() {
        $(".comment-form-controls").show();
    });


    // estimote custom js
    $('#faq h4').click(function() {
        $(this).next('p').toggle()
    });

    // comments box edit
    $("#article ul.comment-list li.comment .comment-container .comment-body.markdown").prepend(function() {
        var comment = $(this);
        comment.prependTo(comment.parent());
    });

    // comments staff adjustments
    var admins = ['fe9fad5a73d112e9839e891e725cfa789162be52','d6137eb0575d0c6999724c7cc23b0ab54aec9344','7d23d7e42688490adf21a7646b8ea11160dd2929','9f38a9e0175242ec8b0d4847083e6f1286d0cf64','8e3daafea5de01a94837ec7a471e33811de9b257','cc61d942c362ce8aecbe913a37ead2c40ce93a99','b0168c421a42060925c1b17ce0466f76240d207f','18c6733bad66382a8876a9373f67f74f4ed87f29','16cdd396fc1632482b5c83e8f83029787e06e3fb','3b988bd659a67ae0193435038a4f36cbaf289cf0'];
    for(var i =0; i < admins.length; i++){
      $('[data-author-identifier='+ admins[i] +']').addClass('admin');
      $('[data-author-identifier='+ admins[i] +'] .comment-author').append('<span class="staff">staff</span>');
      $('[data-author-identifier='+ admins[i] +'] .answer-author').append('<span class="staff">staff</span>');      
    }
    $('.topic-list').addClass('question-list');

    // add ttile to questions..
    if ((document.location.href.indexOf("questions") && document.location.href.indexOf("filter=recommended") === -1) || document.location.href.indexOf("section") != -1) {
        var zendeskQuestion = document.location.protocol + "//community-data.estimote.com/questions.json?callback=?";
        $.getJSON(zendeskQuestion, {}).done(function(data) {
            //console.log(data);
            if (data.questions) {
                if (localStorage) {
                    localStorage.setItem("questions", JSON.stringify(data.questions));
                }
                var selector = 'li.question a';
                var parentSelector = ".question-title";
                var isSection = false;
                if (document.location.href.indexOf("section") != -1) {
                    selector = '.article-list li a';
                    isSection = true;
                }
                $(selector).each(function(i, v) {
                    var link = $(v).attr('href');
                    if (data.questions[link]) {
                        var text = null;
                        if(data.questions[link].text){
                            text = data.questions[link].text;     
                        }else{
                            text = data.questions[link];
                        }
                        var p = '<p class="e-question-content">' + text + '</p>';
                        var parent = null;
                        if (isSection) {
                            parent = $(v).parent('li');
                            if(document.location.href.indexOf("200364446-Video-Use-Cases") != -1){
                                $('a',parent).wrap('<div class="e_video_box"></div>')   
                                var img = '<span class="e_video_icon"><img src="'+ data.questions[link].img +'" alt="video_icon" /></span>';
                               
                                $('.e_video_box',parent).append(p);
                                 parent.append(img);
                                 $('.e_section_video').addClass('e_section_video_show');
                            }else{
                                $(parent).append(p);
                            }
                        } else {
                            parent = $(v).parent('.question-title');
                            $(p).insertAfter(parent);
                        }
                    }
                });
            }
        }).fail(function(err) {
            console.log(err)
        });
    }
    //add breadcrumbs
    if (document.location.href.indexOf('questions') != -1) {
        var breadcrumbs = '<nav class="sub-nav sub-nav-far clearfix"><ol class="breadcrumbs"><li><a href="/hc/en-us">Estimote Community Portal</a></li><li><a href="/hc/communities/public/questions">Questions</a></li></ol></nav>';
        $(breadcrumbs).insertBefore("#questions-content .container .grid");
    }
    //change title to articles
    if(document.location.href.indexOf('articles') != -1){
      $(".e_mainTitle").text($("ol li a:last").text());
    }
    
    // hide voting option
    $('.questions .vote').remove();
    //nailthtumb
    $('.answer-avatar').nailthumb();
    $('.answer-avatar').css("display","block");
    $('.question-avatar').nailthumb();
    $('.question-avatar').css("display","block");    
});