/* 

The core class of the app. It controls most of the actions, callbacks and events.

*/

import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';
import './App.css';
import Header from './Header';
import PreviewBox from './PreviewBox';
import update from 'react-addons-update';
import PreviewEmail from './PreviewEmail';
import CreateEmail from './CreateEmail';
import 'bootstrap/dist/js/bootstrap.min';
// import 'bootstrap/dist/css/bootstrap.min.css';
import Config from './Config';
import Guid from 'guid';
import _ from 'lodash';
import $ from 'jquery';
class App extends Component {
  getDefaultSite = () => {
    var h = window.location.host;
    var defaultSite =   (h === 'ia-cms-lastwordmedia-com.lastword.staging.wpengine.com' || h === 'international-adviser.com') ? 'wp_3_' :
                          ((h === 'fsa-cms-lastwordmedia-com.lastword.staging.wpengine.com' || h === 'fundselectorasia.com') ? 'wp_4_' :
                            ((h === 'ei-cms-lastwordmedia-com.lastword.staging.wpengine.com' || h === 'expertinvestoreurope.com') ? 'wp_5_' : 'wp_2_' ));

    return defaultSite;
  };

  state = {
    page: 'Dashboard',
    showPreview: false,
    previewBoxContent: '',
    previewBoxTimestamp: 0,
    previewBoxId: '',
    param_email_id: 0,
    emails: [],
    categories:[],
    types:[],
    totalEmails: 0,
    offset: 0,
    pageNo: 1,
    site: this.getDefaultSite(),
    articles: [],
    otherArticles: [],
    eventArticles: [],
    ratedArticles: [],
    mostViewedArticles: [],
    totalArticles: 0,
    totalOtherArticles: 0,
    totalEventArticles: 0,
    totalRatedArticles: 0,
    selectedArticles: [],
    selectedEventArticles: [],
    selectedEditorArticles: [],
    selectedStoryArticles: {
       wp_2_: {
        articles: []
       },
       wp_3_: {
        articles: []
       },
       wp_4_: {
        articles: []
       },
       wp_5_: {
        articles: []
       }
      },
    selectedMoreNewsArticles: [],
    selectedMostViewedArticles: [],
    selectedMostReadArticles:[],
    selectedInvestmentArticles:[],
    selectedType: 1,
    selectedCategory: 0,
    enableDelete: false,
    isLoadingEmails: true,
    isLoadingCategories: false,
    isLoadingEmail: true,
    isLoadingSearch: false,
    isLoadingLatest: false,
    isLoadingMostRated: false,
    isLoadingStory: false,
    isLoadingEvents: false,
    isLoadingAdestra: false,
    articlePage: 1,
    highlight: '',
    staticHighlight: '',
    hasTopLeaderboard: "0",
    hasFooterLeaderboard: "0",
    hasNewsletterSubscribe: "0",
    hasSponsoredContent: "0",
    hasSponsoredContent2:"0",
    hasStaticImage1:"0",
    hasStaticImage2:"0",
    hasAssetClass: "0",
    hasQuotable:"0",
    
    topLeaderboard: '',
    topLeaderboardB: '',
    topLeaderboardC: '',
    topLeaderboardD: '',
    topLeaderboardE: '',
    topLeaderboardF: '',
    
    footerLeaderboard: '',
    footerLeaderboardB: '',
    footerLeaderboardC: '',
    footerLeaderboardD: '',
    footerLeaderboardE: '',
    footerLeaderboardF: '',
    
    sponsoredContent: '',
    sponsoredContentB: '',
    sponsoredContentC: '',
    sponsoredContentD: '',
    sponsoredContentE: '',
    sponsoredContentF: '',
    
    sponsoredContent2:'',
    sponsoredContent2B:'',
    sponsoredContent2C:'',
    sponsoredContent2D:'',
    sponsoredContent2E:'',
    sponsoredContent2F:'',
    
    newsletterSubscribe: '',
    digitalMagazine: '',
    
    staticImage1: '',
    staticImage1B: '',
    staticImage1C: '',
    staticImage1D: '',
    
    staticImage2: '',
    staticImage2B: '',
    staticImage2C: '',
    staticImage2D: '',
    
    assetClass: '',
    assetClassB: '',
    assetClassC: '',

    articleRatedPage: 1,
    selectedTab: 'Latest',
    quotable:''
  };

  onNextArticleRatedPage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage + 1
    }),() => this.getMostRatedPosts(this.state.articleRatedPage));
  }

  onPrevRatedArticlePage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage - 1
    }),() => this.getMostRatedPosts(this.state.articleRatedPage));
  }

  setSelectedTab = (tab) => {
    this.setState(prevState => ({selectedTab: tab}), () => {
      switch(tab){
       case 'Latest':
         if(this.state.selectedCategory === 0){
          this.getLatestPosts();
         }
         else{
           this.getPosts();
         }
         break;
       case 'MostRated':
          this.getMostRatedPosts(this.state.articleRatedPage);
         break;
       case 'Search':
         this.resetArticles();
         break;
       default:
        // do nothing
      }
    });
  }

  onTypeChange = (value) => {
    this.setState(prevState => ({
      selectedType: value}));
  }

  pushToAdestra = () => {
    $(ReactDOM.findDOMNode(this.refs.mdlProcessingAdestra)).trigger('click');
    this.setState(prevState => ({isLoadingAdestra: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email?emailId='+ this.state.param_email_id + '&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     this.setState(prevState => ({isLoadingEmail: false}))
     result.json().then(val => {
      var project_id = 0;
      switch(this.state.site){
       case 'wp_2_':
         project_id = 2;
         break;
       case 'wp_3_':
        project_id = 1;
         break;
       case 'wp_4_':
        project_id = 4;
         break;
       case 'wp_5_':
        project_id = 3;
         break;
       default:
      }
      var styleTag = val.Content.match(/<style([\S\s]*?)>([\S\s]*?)<\/style>/ig);
      val.Content = val.Content.replace(/<style([\S\s]*?)>([\S\s]*?)<\/style>/ig, '');
      var content = '<!doctype html>' +
                  '<html xmlns="http://www.w3.org/1999/xhtml">' +
                  '<head>' +
                  '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />' +
                  '<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=2.0,minimum-scale=1.0" />' +
                  '<meta charset="utf-8">' +
                   '<title>Last Word Emails</title>{{TOKEN_HEAD_STRING}}' +
                   //+ styleTag[0] +
                   '</head>' +
                   '<body>{{TOKEN_BODY_STRING}}' +
                   //+ val.Content +
                   '</body>' +
               '</html>';

      content = content.replace( "{{TOKEN_HEAD_STRING}}", styleTag[0] );
      content = content.replace( "{{TOKEN_BODY_STRING}}", val.Content );

      content = content.replace(/’/g,"'");
      content = content.replace(/‘/g,"'");
      content = content.replace(/data-width/g,"width");
      content = content.replace(/data-bgcolor/g,"bgcolor");
      content = content.replace(/data-align/g,"align");
      content = content.replace(/data-border/g,"border");
      content = content.replace(/data-valign/g,"valign");
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/adestra', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
         project_id: project_id,
         content: content,
         name: val.EmailName,
         subject: val.EmailSubject,
         emailId: val.EmailId,
         site: this.state.site
        })
      }).then(result => {
        result.json().then(val => {
          this.setState(prevState => ({isLoadingAdestra: false}))
          $(ReactDOM.findDOMNode(this.refs.mdlProcessingAdestra)).trigger('click');
          this.onChangePage('Dashboard');
        });
      });
     });
    }).catch(err => {
      this.setState(prevState => ({isLoadingEmail: false}))
    });
  }

  onChangeStaticStatus = (name, val) => {
    switch(name){
     
     case 'Top_Leaderboard':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "1" : "0"}));
       break;
     case 'Top_Leaderboard_b':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "2" : "0"}));
       break;
     case 'Top_Leaderboard_c':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "3" : "0"}));
       break;
     case 'Top_Leaderboard_d':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "4" : "0"}));
       break;
     case 'Top_Leaderboard_e':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "5" : "0"}));
       break;
     case 'Top_Leaderboard_f':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "6" : "0"}));
       break;
    
    case 'Footer_Leaderboard':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "1" : "0"}));
      break;
    case 'Footer_Leaderboard_b':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "2" : "0"}));
      break;
    case 'Footer_Leaderboard_c':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "3" : "0"}));
      break;
    case 'Footer_Leaderboard_d':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "4" : "0"}));
      break;
    case 'Footer_Leaderboard_e':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "5" : "0"}));
      break;
    case 'Footer_Leaderboard_f':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "6" : "0"}));
      break;
    
    case 'Newsletter_Subscribe':
      this.setState(prevState => ({ hasNewsletterSubscribe: val === true ? "1" : "0"}));
      break;

    case 'Sponsored_Content':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "1" : "0"}));
      break;
    case 'Sponsored_Content_b':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "2" : "0"}));
      break;
    case 'Sponsored_Content_c':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "3" : "0"}));
      break;
    case 'Sponsored_Content_d':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "4" : "0"}));
      break;
    case 'Sponsored_Content_e':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "5" : "0"}));
      break;
    case 'Sponsored_Content_f':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "6" : "0"}));
      break;
    
    case 'Sponsored_Content_2':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "1" : "0"}));
      break;
    case 'Sponsored_Content_2b':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "2" : "0"}));
      break;
    case 'Sponsored_Content_2c':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "3" : "0"}));
      break;
    case 'Sponsored_Content_2d':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "4" : "0"}));
      break;
    case 'Sponsored_Content_2e':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "5" : "0"}));
      break;
    case 'Sponsored_Content_2f':
      this.setState(prevState => ({ hasSponsoredContent2: val === true ? "6" : "0"}));
      break;
    
    case 'Static_Image_1':
      this.setState(prevState => ({ hasStaticImage1: val === true ? "1" : "0"}));
      break;
    case 'Static_Image_1b':
      this.setState(prevState => ({ hasStaticImage1: val === true ? "2" : "0"}));
      break;
    case 'Static_Image_1c':
      this.setState(prevState => ({ hasStaticImage1: val === true ? "3" : "0"}));
      break;
    case 'Static_Image_1d':
      this.setState(prevState => ({ hasStaticImage1: val === true ? "4" : "0"}));
      break;
    
    case 'Static_Image_2':
      this.setState(prevState => ({ hasStaticImage2: val === true ? "1" : "0"}));
      break;
    case 'Static_Image_2b':
      this.setState(prevState => ({ hasStaticImage2: val === true ? "2" : "0"}));
      break;
    case 'Static_Image_2c':
      this.setState(prevState => ({ hasStaticImage2: val === true ? "3" : "0"}));
      break;
    case 'Static_Image_2d':
      this.setState(prevState => ({ hasStaticImage2: val === true ? "4" : "0"}));
      break;

    case 'Asset_Class':
      this.setState(prevState => ({ hasAssetClass: val === true ? "1" : "0"}));
      break;
    case 'Asset_Class_b':
      this.setState(prevState => ({ hasAssetClass: val === true ? "2" : "0"}));
      break;
    case 'Asset_Class_c':
      this.setState(prevState => ({ hasAssetClass: val === true ? "3" : "0"}));
      break;
    
    case 'Quotable':
      this.setState(prevState => ({ hasQuotable: val === true ? "1" : "0"}));
      break;
    default:
      // do nothing
    }
  }

  onRemoveStatic = (event) => {
    this.onChangeStaticStatus(event.target.id, false);
    switch(event.target.id){
    
    case 'Top_Leaderboard':
       this.setState(prevState => ({ topLeaderboard: ''}));
       break;
    
    case 'Footer_Leaderboard':
      this.setState(prevState => ({ footerLeaderboard: ''}));
      break;
    
    case 'Newsletter_Subscribe':
      this.setState(prevState => ({ newsletterSubscribe: ''}));
      break;
    
    case 'Sponsored_Content':
      this.setState(prevState => ({ sponsoredContent: ''}));
      break;
    
    case 'Sponsored_Content_2':
      this.setState(prevState => ({ sponsoredContent2: ''}));
      break;
    
    case 'Digital_Magazine':
      this.setState(prevState => ({ digitalMagazine: ''}));
      break;
    case 'Static_Image_1':
      this.setState(prevState => ({ staticImage1: ''}));
      break;
    case 'Static_Image_2':
      this.setState(prevState => ({ staticImage2: ''}));
      break;
    case 'Asset_Class':
      this.setState(prevState => ({ assetClass: ''}));
      break;
    case 'Quotable':
      this.setState(prevState => ({ quotable: ''}));
      break;
    default:
      // do nothing
    }
  }

  onStaticDropped = (name, template) => {
    if(name !== undefined){

    this.onChangeStaticStatus(name, true);
     fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ template +'&type='+ name +'&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
       method: 'GET',
       headers: {
         'Accept': 'application/json',
         'Content-Type': 'application/json',
       }
     }).then(result => {
       result.json().then(val => {
         if(val !== null){
          _.each(val, leaderBoard => {

           switch(leaderBoard.Type){

            case 'Top_Leaderboard':
              this.setState(prevState => ({ topLeaderboard: leaderBoard.Content}));
              break;
            case 'Top_Leaderboard_b':
              this.setState(prevState => ({ topLeaderboardB: leaderBoard.Content}));
              break;
            case 'Top_Leaderboard_c':
              this.setState(prevState => ({ topLeaderboardC: leaderBoard.Content}));
              break;
            case 'Top_Leaderboard_d':
              this.setState(prevState => ({ topLeaderboardD: leaderBoard.Content}));
              break;
            case 'Top_Leaderboard_e':
              this.setState(prevState => ({ topLeaderboardE: leaderBoard.Content}));
              break;
            case 'Top_Leaderboard_f':
              this.setState(prevState => ({ topLeaderboardF: leaderBoard.Content}));
              break;

           case 'Footer_Leaderboard':
             this.setState(prevState => ({ footerLeaderboard: leaderBoard.Content}));
             break;
           case 'Footer_Leaderboard_b':
             this.setState(prevState => ({ footerLeaderboardB: leaderBoard.Content}));
             break;
           case 'Footer_Leaderboard_c':
             this.setState(prevState => ({ footerLeaderboardC: leaderBoard.Content}));
             break;
           case 'Footer_Leaderboard_d':
             this.setState(prevState => ({ footerLeaderboardD: leaderBoard.Content}));
             break;
           case 'Footer_Leaderboard_e':
             this.setState(prevState => ({ footerLeaderboardE: leaderBoard.Content}));
             break;
           case 'Footer_Leaderboard_f':
             this.setState(prevState => ({ footerLeaderboardF: leaderBoard.Content}));
             break;

           case 'Newsletter_Subscribe':
             this.setState(prevState => ({ newsletterSubscribe: leaderBoard.Content}));
             break;

           case 'Sponsored_Content':
             this.setState(prevState => ({ sponsoredContent: leaderBoard.Content}));
             break;
           case 'Sponsored_Content_b':
             this.setState(prevState => ({ sponsoredContentB: leaderBoard.Content}));
             break;
           case 'Sponsored_Content_c':
             this.setState(prevState => ({ sponsoredContentC: leaderBoard.Content}));
             break;
           case 'Sponsored_Content_d':
             this.setState(prevState => ({ sponsoredContentD: leaderBoard.Content}));
             break;
           case 'Sponsored_Content_e':
             this.setState(prevState => ({ sponsoredContentE: leaderBoard.Content}));
             break;
           case 'Sponsored_Content_f':
             this.setState(prevState => ({ sponsoredContentF: leaderBoard.Content}));
             break;

           case 'Sponsored_Content_2':
            this.setState(prevState => ({ sponsoredContent2: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2b':
            this.setState(prevState => ({ sponsoredContent2B: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2c':
            this.setState(prevState => ({ sponsoredContent2C: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2d':
            this.setState(prevState => ({ sponsoredContent2D: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2e':
            this.setState(prevState => ({ sponsoredContent2E: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2f':
            this.setState(prevState => ({ sponsoredContent2F: leaderBoard.Content}));
            break;

          case 'Digital_Magazine':
             this.setState(prevState => ({ digitalMagazine: leaderBoard.Content}));
             break;
           case 'Digital_Magazine_2':
             this.setState(prevState => ({ digitalMagazine: leaderBoard.Content}));
             break;

          case 'Static_Image_1':
            this.setState(prevState => ({ staticImage1: leaderBoard.Content}));
            break;
          case 'Static_Image_1b':
            this.setState(prevState => ({ staticImage1B: leaderBoard.Content}));
            break;
          case 'Static_Image_1c':
            this.setState(prevState => ({ staticImage1C: leaderBoard.Content}));
            break;
          case 'Static_Image_1d':
            this.setState(prevState => ({ staticImage1D: leaderBoard.Content}));
            break;

           case 'Static_Image_2':
            this.setState(prevState => ({ staticImage2: leaderBoard.Content}));
            break;
          case 'Static_Image_2b':
            this.setState(prevState => ({ staticImage2B: leaderBoard.Content}));
            break;
          case 'Static_Image_2c':
            this.setState(prevState => ({ staticImage2C: leaderBoard.Content}));
            break;
          case 'Static_Image_2d':
            this.setState(prevState => ({ staticImage2D: leaderBoard.Content}));
            break;

          case 'Asset_Class':
           this.setState(prevState => ({ assetClass: leaderBoard.Content}));
           break;
          case 'Asset_Class_b':
           this.setState(prevState => ({ assetClassB: leaderBoard.Content}));
           break;
          case 'Asset_Class_c':
           this.setState(prevState => ({ assetClassC: leaderBoard.Content}));
           break;

          case 'Quotable':
           this.setState(prevState => ({ quotable: leaderBoard.Content}));
           break;
          default:
            // do nothing
           }
          });
         }
       });
     }).catch(err => console.log(err));
    }
    else{
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ template +'&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
      result.json().then(val => {
        if(val !== null){

          this.setState(prevState => ({ topLeaderboard: '', footerLeaderboard: '', newsletterSubscribe: '', sponsoredContent: '', sponsoredContent2:'', digitalMagazine: '', staticImage1: '', staticImage2: '', assetClass: '', quotable: ''}));
         _.each(val, leaderBoard => {

          switch(leaderBoard.Type){
           case 'Top_Leaderboard':
             this.setState(prevState => ({ topLeaderboard: leaderBoard.Content}));
             break;
           case 'Top_Leaderboard_b':
             this.setState(prevState => ({ topLeaderboardB: leaderBoard.Content}));
             break;
           case 'Top_Leaderboard_c':
             this.setState(prevState => ({ topLeaderboardC: leaderBoard.Content}));
             break;
           case 'Top_Leaderboard_d':
             this.setState(prevState => ({ topLeaderboardD: leaderBoard.Content}));
             break;
           case 'Top_Leaderboard_e':
             this.setState(prevState => ({ topLeaderboardE: leaderBoard.Content}));
             break;
           case 'Top_Leaderboard_f':
             this.setState(prevState => ({ topLeaderboardF: leaderBoard.Content}));
             break;
          
          case 'Footer_Leaderboard':
            this.setState(prevState => ({ footerLeaderboard: leaderBoard.Content}));
            break;
          case 'Footer_Leaderboard_b':
            this.setState(prevState => ({ footerLeaderboardB: leaderBoard.Content}));
            break;
          case 'Footer_Leaderboard_c':
            this.setState(prevState => ({ footerLeaderboardC: leaderBoard.Content}));
            break;
          case 'Footer_Leaderboard_d':
            this.setState(prevState => ({ footerLeaderboardD: leaderBoard.Content}));
            break;
          case 'Footer_Leaderboard_e':
            this.setState(prevState => ({ footerLeaderboardE: leaderBoard.Content}));
            break;
          case 'Footer_Leaderboard_f':
            this.setState(prevState => ({ footerLeaderboardF: leaderBoard.Content}));
            break;
          
          case 'Newsletter_Subscribe':
            this.setState(prevState => ({ newsletterSubscribe: leaderBoard.Content}));
            break;
          
          case 'Sponsored_Content':
            this.setState(prevState => ({ sponsoredContent: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_b':
            this.setState(prevState => ({ sponsoredContentB: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_c':
            this.setState(prevState => ({ sponsoredContentC: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_d':
            this.setState(prevState => ({ sponsoredContentD: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_e':
            this.setState(prevState => ({ sponsoredContentE: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_f':
            this.setState(prevState => ({ sponsoredContentF: leaderBoard.Content}));
            break;
          
          case 'Sponsored_Content_2':
            this.setState(prevState => ({ sponsoredContent2: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2b':
            this.setState(prevState => ({ sponsoredContent2B: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2c':
            this.setState(prevState => ({ sponsoredContent2C: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2d':
            this.setState(prevState => ({ sponsoredContent2D: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2e':
            this.setState(prevState => ({ sponsoredContent2E: leaderBoard.Content}));
            break;
          case 'Sponsored_Content_2f':
            this.setState(prevState => ({ sponsoredContent2F: leaderBoard.Content}));
            break;
          
          case 'Digital_Magazine':
            this.setState(prevState => ({ digitalMagazine: leaderBoard.Content}));
            break;
          case 'Digital_Magazine_2':
            this.setState(prevState => ({ digitalMagazine: leaderBoard.Content}));
            break;
          
          case 'Static_Image_1':
            this.setState(prevState => ({ staticImage1: leaderBoard.Content}));
            break;
          case 'Static_Image_1b':
            this.setState(prevState => ({ staticImage1B: leaderBoard.Content}));
            break;
          case 'Static_Image_1c':
            this.setState(prevState => ({ staticImage1C: leaderBoard.Content}));
            break;
          case 'Static_Image_1d':
            this.setState(prevState => ({ staticImage1D: leaderBoard.Content}));
            break;
          
          case 'Static_Image_2':
            this.setState(prevState => ({ staticImage2: leaderBoard.Content}));
            break;
          case 'Static_Image_2b':
            this.setState(prevState => ({ staticImage2B: leaderBoard.Content}));
            break;
          case 'Static_Image_2c':
            this.setState(prevState => ({ staticImage2C: leaderBoard.Content}));
            break;
          case 'Static_Image_2d':
            this.setState(prevState => ({ staticImage2D: leaderBoard.Content}));
            break;
          
          case 'Asset_Class':
            this.setState(prevState => ({ assetClass: leaderBoard.Content}));
            break;
          case 'Asset_Class_b':
            this.setState(prevState => ({ assetClassB: leaderBoard.Content}));
            break;
          case 'Asset_Class_c':
            this.setState(prevState => ({ assetClassC: leaderBoard.Content}));
            break;
          
          case 'Quotable':
            this.setState(prevState => ({ quotable: leaderBoard.Content}));
            break;
          }
         });
        }
      });
    }).catch(err => console.log(err));
    }
  }

  onStaticDragged = (props) => {
    if(props.name === 'Top_Leaderboard' || props.name === 'Top_Leaderboard_b' || props.name === 'Top_Leaderboard_c' || props.name === 'Top_Leaderboard_d' || props.name === 'Top_Leaderboard_e' || props.name === 'Top_Leaderboard_f'){
     this.setState(prevState => ({staticHighlight: 'top'}));
    }
    else if(props.name === 'Footer_Leaderboard' || props.name === 'Footer_Leaderboard_b' || props.name === 'Footer_Leaderboard_c' || props.name === 'Footer_Leaderboard_d' || props.name === 'Footer_Leaderboard_e' || props.name === 'Footer_Leaderboard_f'){
     this.setState(prevState => ({staticHighlight: 'footer'}));
    }
    else if(props.name === 'Sponsored_Content' || props.name === 'Sponsored_Content_b' || props.name === 'Sponsored_Content_c' || props.name === 'Sponsored_Content_d' || props.name === 'Sponsored_Content_e' || props.name === 'Sponsored_Content_f'){
     this.setState(prevState => ({staticHighlight: 'sponsoredContent'}));
    }
    else if(props.name === 'Sponsored_Content_2' || props.name === 'Sponsored_Content_2b' || props.name === 'Sponsored_Content_2c' || props.name === 'Sponsored_Content_2d' || props.name === 'Sponsored_Content_2e' || props.name === 'Sponsored_Content_2f'){
     this.setState(prevState => ({staticHighlight: 'sponsoredContent2'}));
    }
    else if(props.name === 'Digital_Magazine' || props.name === 'Digital_Magazine_2'){
     this.setState(prevState => ({staticHighlight: 'digitalMagazine'}));
    }
    else if(props.name === 'Newsletter_Subscribe'){
     this.setState(prevState => ({staticHighlight: 'newsletter'}));
    }
    else if(props.name === 'Static_Image_1' || props.name === 'Static_Image_1b' || props.name === 'Static_Image_1c' || props.name === 'Static_Image_1d'){
     this.setState(prevState => ({staticHighlight: 'staticImage1'}));
    }
    else if(props.name === 'Static_Image_2' || props.name === 'Static_Image_2b' || props.name === 'Static_Image_2c' || props.name === 'Static_Image_2d'){
     this.setState(prevState => ({staticHighlight: 'staticImage2'}));
    }
    else if(props.name === 'Asset_Class' || props.name === 'Asset_Class_b' || props.name === 'Asset_Class_c'){
     this.setState(prevState => ({staticHighlight: 'assetClass'}));
    }
    else if(props.name === 'Quotable'){
     this.setState(prevState => ({staticHighlight: 'quotable'}));
    }
  }

  onCancelStaticDrag = () => {
    this.setState(prevState => ({staticHighlight: ''}));
  }

  onCancelDrag = () => {
    this.setState(prevState => ({highlight: ''}));
  }

  onArticleDragged = (props) => {
    this.setState(prevState => ({highlight: props.type}));
  }

  onNextArticlePage = () => {
    this.setState(prevState => ({
      articlePage: this.state.articlePage + 1
    }),() => this.getPosts());
  }

  onPrevArticlePage = () => {
    this.setState(prevState => ({
      articlePage: this.state.articlePage - 1
    }),() => this.getPosts());
  }

  onCategoryChange = (value) => {
    this.setState({
      selectedCategory: value
    }, () => {
      if(parseInt(this.state.selectedCategory, 10) !== 0){
        this.getPosts();
      }
      else{
       this.getLatestPosts();
      }
    });
  }

  onChangeTemplate = () => {
    this.setState({
      selectedArticles: [],
      hasDigitalMagazine: "0",
      hasTopLeaderboard: "0",
      hasFooterLeaderboard: "0",
      hasNewsletterSubscribe: "0",
      hasSponsoredContent: "0",
      hasSponsoredContent2:"0",
      hasStaticImage1: "0",
      hasStaticImage2: "0",
      hasAssetClass: "0",
      hasQuotable: "0"
    });
  }

  onRemoveEditor = (event) => {
    this.setState({selectedEditorArticles: this.state.selectedEditorArticles.filter((article) => {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID, 10) === parseInt(event.target.id, 10)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  onRemoveEvent = (event) => {
    this.setState({selectedEventArticles: this.state.selectedEventArticles.filter((article) => {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
      _.each(this.state.eventArticles, (article, index) => {
       if(parseInt(article.ID, 10) === parseInt(event.target.id, 10)){
        this.setState({
          eventArticles: update(this.state.eventArticles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  resetArticles = () => {
    this.setState(prevState => ({articles : [], totalArticles: 0}))
  }

  getMostRatedPosts = (page) => {
    this.setState(prevState => ({ratedArticles : [], totalRatedArticles: 0, isLoadingMostRated: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsmostrated?page='+ page + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
         this.setState(prevState => ({ratedArticles : val[0], totalRatedArticles: val[1]}))
       }
      this.setState(prevState => ({isLoadingMostRated: false}))
     }).catch(err => {
      this.setState(prevState => ({isLoadingMostRated: false}))
     });
    });
  }

  getPosts = () => {
    this.setState({articles : [], totalArticles: 0, isLoadingLatest: true})
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/posts?categoryId='+ this.state.selectedCategory +'&page='+ this.state.articlePage + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
         this.setState({articles : val[0], totalArticles: val[1]})
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
      this.setState({isLoadingLatest: false})
     }).catch(err => {
      this.setState({isLoadingLatest: false})
     });
    });
  }

  getLatestPostsBySite = () => {
    this.setState({articles : [], totalArticles: 0, isLoadingLatest: true})
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/latestpostsbysite?cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
         let storyArticles = {
          wp_2_: {
           articles: val["0"]
          },
          wp_3_: {
           articles: val["1"]
          },
          wp_4_: {
           articles: val["2"]
          },
          wp_5_: {
           articles: val["3"]
          }
         }
         
         // val["0"].site = 'wp_2_';
         // val["1"].site = 'wp_3_';
         // val["2"].site = 'wp_4_';
         // val["3"].site = 'wp_5_';
         this.setState(prevState => ({ selectedStoryArticles: storyArticles}));
         // this.setState(prevState => ({ selectedStoryArticles: [...prevState.selectedStoryArticles, val["1"]]}));
         // this.setState(prevState => ({ selectedStoryArticles: [...prevState.selectedStoryArticles, val["2"]]}));
         // this.setState(prevState => ({ selectedStoryArticles: [...prevState.selectedStoryArticles, val["3"]]}));
      this.setState({isLoadingLatest: false})
     }).catch(err => {
      this.setState({isLoadingLatest: false})
     });
    });
  }
  getLatestPosts = () => {
    this.setState({articles : [], totalArticles: 0, isLoadingLatest: true})
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/latestposts?prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
         this.setState({articles : val[0], totalArticles: val[1]})
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
      this.setState({isLoadingLatest: false})
     }).catch(err => {
      this.setState({isLoadingLatest: false})
     });
    });
  }
  getPostsByType = (type, searchFor) => {
    this.setState(prevState => ({isLoadingSearch: true}))
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsbytype?type='+ type + '&search='+ searchFor + '&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then(result => {
        this.setState(prevState => ({isLoadingSearch: false}))
       result.json().then(val => {
         this.setState(prevState => ({articles : val[0], totalArticles: val[1]}))
       }).catch(err => {
        this.setState(prevState => ({isLoadingSearch: false}))
       });
      });
  }

  getPostsBySite = (site, searchFor) => {
    this.setState(prevState => ({isLoadingStory: true}))
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsbysite?site='+ site + '&search='+ searchFor + '&cache='+ Guid.raw(), {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then(result => {
        this.setState(prevState => ({isLoadingStory: false}))
       result.json().then(val => {
         this.setState(prevState => ({otherArticles : val[0], totalOtherArticles: val[1]}))
       }).catch(err => {
        this.setState(prevState => ({isLoadingStory: false}))
       });
      });
  }
  getPostsByEvent = (searchFor) => {
    this.setState(prevState => ({isLoadingEvents: true}))
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsbyevent?site='+ this.state.site +'&search='+ searchFor + '&cache='+ Guid.raw(), {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then(result => {
        this.setState(prevState => ({isLoadingEvents: false}))
       result.json().then(val => {
         this.setState(prevState => ({eventArticles : val[0], totalEventArticles: val[1]}))
       }).catch(err => {
        this.setState(prevState => ({isLoadingEvents: false}))
       });
      });
  }
  onArticleDropped = (articleId, type, site) => {
    this.setState(prevState => ({highlight: ''}));
    if(type === 'Latest_News' || type === 'Search'){
        if(parseInt(this.state.selectedCategory, 10) === 35){
          _.each(this.state.articles, (article, index) => {
           if(parseInt(article.ID, 10) === articleId){
             this.setState(prevState => ({
               selectedEventArticles: [...prevState.selectedEventArticles, article]
             }));
             this.setState({
               articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
             })
           }
          })
        }
        else{
          _.each(this.state.articles, (article, index) => {
           if(parseInt(article.ID, 10) === articleId){
             this.setState(prevState => ({
               selectedArticles: [...prevState.selectedArticles, article]
             }));
             this.setState({
               articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
             })
           }
          })
        }
      }
      else if(type === 'Most_Viewed'){
        let articleFound = false;

        _.each(this.state.ratedArticles, (article, index) => {
         if(parseInt(article.ID, 10) === articleId){
           this.setState(prevState => ({
             selectedMostViewedArticles: [...prevState.selectedMostViewedArticles, article]
           }));
           this.setState({
             ratedArticles: update(this.state.ratedArticles, {[index]: {isDisabled: {$set: true}}})
           })
           articleFound = true;
         }
        })

        if ( !articleFound ) {
          _.each(this.state.articles, (article, index) => {
           if(parseInt(article.ID, 10) === articleId){
             this.setState(prevState => ({
               selectedMostViewedArticles: [...prevState.selectedMostViewedArticles, article]
             }));
             this.setState({
               articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
             })
           }
          })
        }
    }
    else if(type === 'Investment'){
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID, 10) === articleId){
         this.setState(prevState => ({
           selectedInvestmentArticles: [...prevState.selectedInvestmentArticles, article]
         }));
         this.setState({
           articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
         })
       }
      })
    }
    else if(type === 'Most_Read'){
      let articleFound = false;

      _.each(this.state.ratedArticles, (article, index) => {
       if(parseInt(article.ID, 10) === articleId){
         this.setState(prevState => ({
           selectedMostReadArticles: [...prevState.selectedMostReadArticles, article]
         }));
         this.setState({
           ratedArticles: update(this.state.ratedArticles, {[index]: {isDisabled: {$set: true}}})
         })
         articleFound = true;
       }
      })

      if ( !articleFound ) {
        _.each(this.state.articles, (article, index) => {
         if(parseInt(article.ID, 10) === articleId){
           this.setState(prevState => ({
             selectedMostReadArticles: [...prevState.selectedMostReadArticles, article]
           }));
           this.setState({
             articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
           })
         }
        })
      }
    }
    else if(type === 'Events'){
      _.each(this.state.eventArticles, (article, index) => {
       if(parseInt(article.ID, 10) === articleId){
          var sortCallback = function(r) {
              r.sort(function(a,b){
                return a.startdate > b.startdate;
              });
              
              return r;
          };
          this.setState(prevState => ({
            selectedEventArticles: sortCallback([...prevState.selectedEventArticles, article])
          }));
          this.setState({
            eventArticles: update(this.state.eventArticles, {[index]: {isDisabled: {$set: true}}})
          });
       }
      })
    }
    else if(type === 'Editor_Pick'){
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID, 10) === articleId){
          this.setState(prevState => ({
            selectedEditorArticles: [...prevState.selectedEditorArticles, article]
          }));
          this.setState({
            articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
          })
       }
      })
    }
    else if(type === 'More_News'){
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID, 10) === articleId){
          this.setState(prevState => ({
            selectedMoreNewsArticles: [...prevState.selectedMoreNewsArticles, article]
          }));
          this.setState({
            articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
          })
       }
      })
    }
  }

  onRemoveArticle = (event) => {
    this.setState({selectedArticles: this.state.selectedArticles.filter(function(article) {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
    this.setState({selectedMoreNewsArticles: this.state.selectedMoreNewsArticles.filter(function(article) {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
    this.setState({selectedMostViewedArticles: this.state.selectedMostViewedArticles.filter(function(article) {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
    this.setState({selectedMostReadArticles: this.state.selectedMostReadArticles.filter(function(article) {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
    this.setState({selectedInvestmentArticles: this.state.selectedInvestmentArticles.filter(function(article) {
          return parseInt(article.ID, 10) !== parseInt(event.target.id, 10)
      })});
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID, 10) === parseInt(event.target.id, 10)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
      _.each(this.state.ratedArticles, (article, index) => {
       if(parseInt(article.ID, 10) === parseInt(event.target.id, 10)){
        this.setState({
          ratedArticles: update(this.state.ratedArticles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  getEmail = (callBackFn) => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email?emailId='+ this.state.param_email_id + '&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     this.setState(prevState => ({isLoadingEmail: false}))
     result.json().then(val => {
       var t_articles = val.Articles1;
       var ev_articles = val.EventArticles1;
       var ed_articles = val.EditorArticles1;
       var mv_articles = val.MostViewedArticles1;
       var mr_articles = val.MostReadArticles1;
       var mn_articles = val.MoreNewsArticles1;
       var iv_articles = val.InvestmentArticles1;

       this.setState(prevState => ({ hasDigitalMagazine: val.HasDigitalMagazine,
                                     hasTopLeaderboard: val.HasTopLeaderboard,
                                     hasFooterLeaderboard: val.HasFooterLeaderboard,
                                     hasSponsoredContent: val.HasSponseredContent,
                                     hasSponsoredContent2: val.HasSponseredContent2,
                                     hasNewsletterSubscribe: val.HasNewsletterSubscribe,
                                     hasStaticImage1: val.HasStaticImage1,
                                     hasStaticImage2: val.HasStaticImage2,
                                     hasAssetClass: val.HasAssetClass,
                                     hasQuotable: val.HasQuotable}));

       this.setState(prevState => ({selectedArticles: [], selectedEventArticles: [], selectedEditorArticles: [], selectedMostViewedArticles: [], selectedInvestmentArticles:[], selectedMostReadArticles:[], selectedMoreNewsArticles: []}));
        
       _.each(t_articles, (art) => {
          this.setState(prevState => ({
            selectedArticles : [...prevState.selectedArticles,art]}));
         });
      _.each(ev_articles, (art) => {
         this.setState(prevState => ({
           selectedEventArticles : [...prevState.selectedEventArticles,art]}));
        });
      _.each(ed_articles, (art) => {
         this.setState(prevState => ({
           selectedEditorArticles : [...prevState.selectedEditorArticles,art]}));
        });
      _.each(mv_articles, (art) => {
         this.setState(prevState => ({
           selectedMostViewedArticles : [...prevState.selectedMostViewedArticles,art]}));
        });
      _.each(mr_articles, (art) => {
         this.setState(prevState => ({
           selectedMostReadArticles : [...prevState.selectedMostReadArticles,art]}));
        });
      _.each(iv_articles, (art) => {
         this.setState(prevState => ({
           selectedInvestmentArticles : [...prevState.selectedInvestmentArticles,art]}));
        });
      _.each(mn_articles, (art) => {
         this.setState(prevState => ({
           selectedMoreNewsArticles : [...prevState.selectedMoreNewsArticles,art]}));
        });
       callBackFn(val.EmailName, val.TemplateName);
     });
    }).catch(err => {
      this.setState(prevState => ({isLoadingEmail: false}))
    });
  }

  getEmails = (offset) => {
    this.setState(prevState => ({isLoadingEmails: true}));
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/emails?offset='+ offset + '&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       this.setState({emails : val[0], totalEmails: val[1], isLoadingEmails: false})
     }).catch(err => {
       this.setState(prevState => ({isLoadingEmails: false}));
     });
    });
  };

  onSetSite = (site) => {
    this.setState(prevState => ({ site: site,
                                  offset: 0,
                                  pageNo: 1,
                                  selectedArticles: [],
                                  selectedEventArticles: [],
                                  selectedEditorArticles: [],
                                  selectedMoreNewsArticles: [],
                                  selectedMostViewedArticles: [],
                                  selectedMostReadArticles:[],
                                  selectedInvestmentArticles: [],
                                  hasDigitalMagazine: '0',
                                  hasTopLeaderboard: '0',
                                  hasFooterLeaderboard: '0',
                                  hasNewsletterSubscribe: '0',
                                  hasSponsoredContent: '0',
                                  hasSponsoredContent2: '0',
                                  hasStaticImage1:'0',
                                  hasStaticImage2: '0',
                                  hasAssetClass: '0',
                                  hasQuotable: '0',
                                  topLeaderboard: '',
                                  footerLeaderboard: '',
                                  newsletterSubscribe: '',
                                  sponsoredContent: '',
                                  sponsoredContent2:'',
                                  digitalMagazine: '',
                                  staticImage1: '',
                                  staticImage2: '',
                                  assetClass: '',
                                  articles: [],
                                  otherArticles: [],
                                  eventArticles: [],
                                  ratedArticles: [],
                                  selectedTab: this.state.selectedTab,
                                  articleRatedPage: 1,
                                  quotable: ''}), () => {
     this.getEmails(this.state.offset);
     this.getCategories();
     this.getTypes();
     this.setSelectedTab(this.state.selectedTab);
     this.setState(prevState => ({selectedCategory: 0}));
    });
  }

  getPosts = () => {
    this.setState({articles : [], totalArticles: 0, isLoadingLatest: true})
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/posts?categoryId='+ this.state.selectedCategory +'&page='+ this.state.articlePage + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
         this.setState({articles : val[0], totalArticles: val[1]})
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
      this.setState({isLoadingLatest: false})
     }).catch(err => {
      this.setState({isLoadingLatest: false})
     });
    });
  }

  // getMostRatedPosts = () => {
  //   this.setState(prevState => ({ratedArticles : [], totalRatedArticles: 0, isLoadingMostRated: true}))
  //   fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsmostrated?page='+ this.state.articleRatedPage + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
  //     method: 'GET',
  //     headers: {
  //       'Accept': 'application/json',
  //       'Content-Type': 'application/json',
  //     }
  //   }).then(result => {
  //    result.json().then(val => {
  //      if(val[0].length > 0){
  //       console.log(val);
  //        this.setState(prevState => ({ratedArticles : val[0], totalRatedArticles: val[1]}))
  //      }
  //     this.setState(prevState => ({isLoadingMostRated: false}))
  //    }).catch(err => {
  //     this.setState(prevState => ({isLoadingMostRated: false}))
  //    });
  //   });
  // }
  getCategories = () => {
    this.setState(prevState => ({isLoadingCategories: true}));
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/categories?prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
      if(val.length > 0){
        this.setState({categories : val, isLoadingCategories: false}, () => {
          this.setState(prevState => ({categories: [{id: 0, name: '-- Select Category --'}, ...prevState.categories]}))
          this.getLatestPosts();
         // this.getMostRatedPosts();
        })
      }
     }).catch(err => {
      this.setState(prevState => ({isLoadingCategories: false}));
     });
    });
  }
  getTypes = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/types?prefix='+ this.state.site + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       val.push({id: 1, name: 'All'});
       this.setState({types : val})
     });
    });
  }
  onNextPage = () => {
    this.setState(prevState => ({
      pageNo: prevState.pageNo + 1,
      offset: prevState.offset + 20
    }), () => this.getEmails(this.state.offset));
  }

  onPreviousPage = () => {
    this.setState(prevState => ({
      pageNo: prevState.pageNo - 1,
      offset: prevState.offset - 20
    }), () => this.getEmails(this.state.offset));
  }

  editEmail = (event) => {
   event.preventDefault();
   this.onChangePage('CreateEmail', event.target.id);
  }


  livePreview = (event) => {
   event.preventDefault();

   var isStaging = Config.BASE_URL.indexOf('staging') !== -1;
   var url = '';

   switch (this.state.site) {
    case 'wp_2_':
      url = 'https://pa.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;

      if (isStaging)
        url = 'https://pa-cms-lastwordmedia-com.lastword.staging.wpengine.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;

      window.open(url);
      
      break;
    case 'wp_3_':
      url = 'https://ia.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;
      
      if (isStaging)
        url = 'https://ia-cms-lastwordmedia-com.lastword.staging.wpengine.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;

      window.open(url);
      
      break;
    case 'wp_4_':
      url = 'https://fsa.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;
      
      if (isStaging)
        url = 'https://fsa-cms-lastwordmedia-com.lastword.staging.wpengine.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;

      window.open(url);
      
      break;
    case 'wp_5_':
      url = 'https://ei.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;
      
      if (isStaging)
        url = 'https://ei-cms-lastwordmedia-com.lastword.staging.wpengine.com/email-approve?emailId='+ event.target.id + '&prefix='+ this.state.site;

      window.open(url);
      
      break;

    default:
   }
  }
  onChangePage = (page, param) => {
    this.setState(prevState => ({
      page: page,
      param_email_id: param
    }));
    if(page === 'Dashboard'){
      this.getEmails(this.state.offset);
    }
  };

  componentDidMount = () => {
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
    window.onhashchange=function(){window.location.hash="no-back-button";}
    window.onbeforeunload  = () => {
      // return "Are you sure you want to leave?";
    }
    this.setState(prevState => ({
      site: this.getDefaultSite(),
    }));    
    this.getEmails(this.state.offset);
  }

  onLoadingEmail = (value) => {
    this.setState(prevState => ({isLoadingEmail: false}))
  }

  onCheckChange = (event) => {
  _.each(this.state.emails, (email, index) => {
   if(parseInt(email.EmailId, 10) === parseInt(event.target.id, 10)){
    this.setState({
      emails: update(this.state.emails, {[index]: {isSelected: {$set: !this.state.emails[index].isSelected}}})
    }, () => {
      let count = _.filter(this.state.emails, email => email.isSelected === true);
     if(count.length > 0)
      this.setState(prevState => ({enableDelete: true}))
     else
      this.setState(prevState => ({enableDelete: false}))
    })
   }
  });
  }

  onDeleteEmails = () => {
    let emails = _.filter(this.state.emails, email => email.isSelected === true);
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/deleteemails', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
       emails: _.map(emails, email => email.EmailId).join(',')
      })
    }).then(result => {
      this.getEmails(this.state.offset);
    });
  }

  onShowPreviewBox = (name, template) => {
    var self = this;
    var timestamp = new Date().getTime();
    var id = name + '_' + template + '_' + timestamp;

    self.setState(prevState => ({
      previewBoxId: id,
      previewBoxTimestamp: timestamp
    }));

    setTimeout(function(){
      if ( timestamp === self.state.previewBoxTimestamp && id === self.state.previewBoxId ) {
        self.setState(prevState => ({
          showPreview: true, 
          previewBoxContent: template === '' ? 'Please select the template' : 'Loading... Please wait...'
        }));

        if ( template !== '' ) {
            console.log('call');
            
            fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ template +'&type='+ name +'&prefix='+ self.state.site +'&cache='+ Guid.raw(), {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
              }
            }).then(result => {
              result.json().then(val => {
                if(val !== null) {
                  _.each(val, leaderBoard => {
                    self.setState(prevState => ({previewBoxContent: leaderBoard.Content}));
                });
              }
            });
          }).catch(err => console.log(err));
        }
      }
    }, 2000);
  }
  
  onHidePreviewBox = () => {
    this.setState(prevState => ({showPreview: false, previewBoxContent: '', previewBoxId: '', previewBoxTimestamp: 0}));
  }

  render() {
    return (
      <div className="container">
         <PreviewBox closePreviewBox={this.onHidePreviewBox} show={this.state.showPreview} content={this.state.previewBoxContent} />
         <Header onChangePage={this.onChangePage} currentPage={this.state.page} onSetSite={this.onSetSite} site={this.state.site}/>
         { this.state.page === 'Dashboard' ? 
          <div className="container">
             <div className="row">
               <div className="col-xs-10">
                 <h1>Newsletters</h1>
               </div>
               <div className="col-xs-2">
                <button type="button" style={{marginTop:'20px', marginBottom:'10px'}} disabled={!this.state.enableDelete}  onClick={this.onDeleteEmails} className="btn btn-primary">Delete Emails</button>
               </div>
             </div>
               <div className="row">
                 <div className="col-xs-12">
                { this.state.isLoadingEmails === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif" alt="Loading" /></div> : 
                   <table className="table">
                     <thead>
                       <tr>
                         <th>Email Name</th>
                         <th>Subject</th>
                         <th>Editor</th>
                         <th>Status</th>
                         <th>Saved On</th>
                         <th>Edit</th>
                         <th>Delete</th>
                         <th>Preview</th>
                       </tr>
                     </thead>
                     <tbody>
                     {this.state.emails.map((email, key) => {
                       return <tr key={key}>
                         <td>{email.EmailName}</td>
                         <td>{email.EmailSubject}</td>
                         <td>{email.EditorDisplayName}</td>
                         <td>{email.SendToAdestraOn !== null ? 'Sent to Adestra -'+ moment(email.SendToAdestraOn).format('ddd Do MMM, YYYY') : 'Editing'}</td>
                         <td>{email.UpdatedAt === '0000-00-00 00:00:00' ? '-' : email.UpdatedAt}</td>
                         <td><button type="button" disabled={email.SendToAdestraOn !== null}  id={email.EmailId} onClick={this.editEmail} className="btn btn-primary">Edit</button></td>
                         <td><input type="checkbox" id={email.EmailId} checked={email.isSelected} onChange={this.onCheckChange}/></td>
                         <td><button type="button" id={email.EmailId} onClick={this.livePreview} className="btn btn-primary">Live Preview</button></td>
                       </tr>
                       })}
                     </tbody>
                   </table>}
                 </div>
               </div>
             <div className="row">
               <div className="col-xs-12">
                 <ul className="pager">
                   <li className="previous dis">{this.state.pageNo > 1 ? <button onClick={this.onPreviousPage}>Previous</button> : ''}</li>
                   <li className="next">{this.state.pageNo < Math.ceil(this.state.totalEmails / 20) ? <button onClick={this.onNextPage}>Next</button> : ''}</li>
                 </ul>
               </div>
             </div>
           </div>
           : ''}
         { this.state.page === 'CreateEmail' ?  <CreateEmail

                                                   onShowPreviewBox={this.onShowPreviewBox} 
                                                   onHidePreviewBox={this.onHidePreviewBox}

                                                   onPrevRatedArticlePage={this.onPrevRatedArticlePage}
                                                   onNextRatedArticlePage={this.onNextArticleRatedPage}

                                                   onChangePage={this.onChangePage}
                                                   emailId={this.state.param_email_id}
                                                   site={this.state.site}
                                                   categories={this.state.categories}
                                                   types={this.state.types}
                                                   getCategories={this.getCategories}
                                                   getTypes={this.getTypes}
                                                   getEmail={this.getEmail}
                                                   onRemoveArticle={this.onRemoveArticle}
                                                   onArticleDropped={this.onArticleDropped}
                                                   selectedArticles={this.state.selectedArticles}
                                                   selectedEventArticles={this.state.selectedEventArticles}
                                                   selectedEditorArticles={this.state.selectedEditorArticles}
                                                   selectedStoryArticles={this.state.selectedStoryArticles}
                                                   selectedMoreNewsArticles={this.state.selectedMoreNewsArticles}
                                                   selectedMostViewedArticles={this.state.selectedMostViewedArticles}
                                                   selectedMostReadArticles={this.state.selectedMostReadArticles}
                                                   selectedInvestmentArticles={this.state.selectedInvestmentArticles}
                                                   getPostsByType={this.getPostsByType}
                                                   getPostsBySite={this.getPostsBySite}
                                                   getPostsByEvent={this.getPostsByEvent}
                                                   resetArticles={this.resetArticles}
                                                   getPosts={this.getPosts}
                                                   getMostRatedPosts={this.getMostRatedPosts}
                                                   onChangeTemplate={this.onChangeTemplate}
                                                   onRemoveEvent={this.onRemoveEvent}
                                                   onRemoveEditor={this.onRemoveEditor}
                                                   articles={this.state.articles}
                                                   otherArticles={this.state.otherArticles}
                                                   eventArticles={this.state.eventArticles}
                                                   mostViewedArticles={this.state.mostViewedArticles}
                                                   totalArticles={this.state.totalArticles}
                                                   totalOtherArticles={this.state.totalOtherArticles}
                                                   ratedArticles={this.state.ratedArticles}
                                                   totalRatedArticles={this.state.totalRatedArticles}
                                                   isLoadingEmail={this.state.isLoadingEmail}
                                                   isLoadingSearch={this.state.isLoadingSearch}
                                                   isLoadingLatest={this.state.isLoadingLatest}
                                                   isLoadingMostRated={this.state.isLoadingMostRated}
                                                   isLoadingCategories={this.state.isLoadingCategories}
                                                   isLoadingStory={this.state.isLoadingStory}
                                                   isLoadingEvents={this.state.isLoadingEvents}
                                                   isLoadingAdestra={this.state.isLoadingAdestra}
                                                   onCategoryChange={this.onCategoryChange}
                                                   selectedCategory={this.state.selectedCategory}
                                                   onNextArticlePage={this.onNextArticlePage}
                                                   onPrevArticlePage={this.onPrevArticlePage}
                                                   articlePage={this.state.articlePage}
                                                   onLoadingEmail={this.onLoadingEmail}
                                                   onArticleDragged={this.onArticleDragged}
                                                   onCancelDrag={this.onCancelDrag}
                                                   onCancelStaticDrag={this.onCancelStaticDrag}
                                                   onStaticDragged={this.onStaticDragged}
                                                   onStaticDropped={this.onStaticDropped}
                                                   onRemoveStatic={this.onRemoveStatic}
                                                   onChangeStaticStatus={this.onChangeStaticStatus}
                                                   
                                                   topLeaderboard={this.state.topLeaderboard}
                                                   topLeaderboardB={this.state.topLeaderboardB}
                                                   topLeaderboardC={this.state.topLeaderboardC}
                                                   topLeaderboardD={this.state.topLeaderboardD}
                                                   topLeaderboardE={this.state.topLeaderboardE}
                                                   topLeaderboardF={this.state.topLeaderboardF}
                                                   
                                                   footerLeaderboard={this.state.footerLeaderboard}
                                                   footerLeaderboardB={this.state.footerLeaderboardB}
                                                   footerLeaderboardC={this.state.footerLeaderboardC}
                                                   footerLeaderboardD={this.state.footerLeaderboardD}
                                                   footerLeaderboardE={this.state.footerLeaderboardE}
                                                   footerLeaderboardF={this.state.footerLeaderboardF}
                                                   
                                                   sponsoredContent={this.state.sponsoredContent}
                                                   sponsoredContentB={this.state.sponsoredContentB}
                                                   sponsoredContentC={this.state.sponsoredContentC}
                                                   sponsoredContentD={this.state.sponsoredContentD}
                                                   sponsoredContentE={this.state.sponsoredContentE}
                                                   sponsoredContentF={this.state.sponsoredContentF}
                                                   
                                                   sponsoredContent2={this.state.sponsoredContent2}
                                                   sponsoredContent2B={this.state.sponsoredContent2B}
                                                   sponsoredContent2C={this.state.sponsoredContent2C}
                                                   sponsoredContent2D={this.state.sponsoredContent2D}
                                                   sponsoredContent2E={this.state.sponsoredContent2E}
                                                   sponsoredContent2F={this.state.sponsoredContent2F}
                                                   
                                                   digitalMagazine={this.state.digitalMagazine}
                                                   
                                                   staticImage1={this.state.staticImage1}
                                                   staticImage1B={this.state.staticImage1B}
                                                   staticImage1C={this.state.staticImage1C}
                                                   staticImage1D={this.state.staticImage1D}
                                                   
                                                   staticImage2={this.state.staticImage2}
                                                   staticImage2B={this.state.staticImage2B}
                                                   staticImage2C={this.state.staticImage2C}
                                                   staticImage2D={this.state.staticImage2D}
                                                   
                                                   assetClass={this.state.assetClass}
                                                   assetClassB={this.state.assetClassB}
                                                   assetClassC={this.state.assetClassC}

                                                   quotable={this.state.quotable}
                                                   newsletterSubscribe={this.state.newsletterSubscribe}
                                                   highlight={this.state.highlight}
                                                   staticHighlight={this.state.staticHighlight}
                                                   hasDigitalMagazine={this.state.hasDigitalMagazine}
                                                   hasTopLeaderboard={this.state.hasTopLeaderboard}
                                                   hasFooterLeaderboard={this.state.hasFooterLeaderboard}
                                                   hasNewsletterSubscribe={this.state.hasNewsletterSubscribe}
                                                   hasSponsoredContent={this.state.hasSponsoredContent}
                                                   hasSponsoredContent2={this.state.hasSponsoredContent2}
                                                   hasStaticImage1={this.state.hasStaticImage1}
                                                   hasStaticImage2={this.state.hasStaticImage2}
                                                   hasAssetClass={this.state.hasAssetClass}
                                                   hasQuotable={this.state.hasQuotable}
                                                   pushToAdestra={this.pushToAdestra}
                                                   selectedType={this.state.selectedType}
                                                   onTypeChange={this.onTypeChange}
                                                   selectedTab={this.state.selectedTab}
                                                   setSelectedTab={this.setSelectedTab}
                                                   articleRatedPage={this.state.articleRatedPage}
                                                   onNextArticleRatedPage={this.onNextArticleRatedPage}
                                                   onPrevArticleRatedPage={this.onPrevArticleRatedPage}
                                                   getLatestPosts={this.getLatestPosts}
                                                   getLatestPostsBySite={this.getLatestPostsBySite}
                                                   /> : ''}
         { this.state.page === 'PreviewEmail' ? <PreviewEmail onChangePage={this.onChangePage} emailId={this.state.param_email_id} site={this.state.site}/>  : ''}
        <button data-toggle="modal" data-target="#mdlProcessingAdestra" ref="mdlProcessingAdestra" style={{position: 'absolute',bottom: '0px'}}></button>
        <div id="mdlProcessingAdestra" className="modal fade" role="dialog" ref="modal">
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-body">
                   {this.state.isLoadingAdestra === true ? <h2>Sending to Adestra. Please wait...</h2> : ''}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default App;
