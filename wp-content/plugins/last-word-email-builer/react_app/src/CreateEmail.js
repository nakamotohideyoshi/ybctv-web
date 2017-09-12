import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import update from 'react-addons-update';
import VideoNewsLetter from './VideoNewsLetter';
import InsightsNewsLetter from './InsightsNewsLetter';
import DigitalMagazineNewsLetter from './DigitalMagazineNewsLetter';
import BreakingNewsNewsLetter from './BreakingNewsNewsLetter';
import PortfolioAdviserNewsLetter from './PortfolioAdviserNewsLetter';
import DragArticle from './DragArticle';
import DragStatic from './DragStatic';
import CreateStatic from './CreateStatic';
import Article from './Article';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';

class CreateEmail extends Component {
  state = { 
      templates: [{name: '-- Select Email Newsletter --'},
                {name: 'Portfolio Adviser Newsletter', value: 'Portfolio_Adviser_Newsletter'},
                {name: 'Breaking News Newsletter', value: 'Breaking_News_Newsletter'},
                {name: 'Digital Magazine Newsletter', value: 'Digital_Magazine_Newsletter'},
                {name: 'Insights Newsletter', value: 'Insights_Newsletter'},
                {name: 'Video Newsletter', value: 'Video_Newsletter'}],
    template: '',
    selectedTab: 'Latest',
    selectedArticles: [],
    selectedEventArticles: [],
    selectedEditorArticles: [],
    articles: [],
    ratedArticles: [],
    articlePage: 1,
    articleRatedPage: 1,
    totalArticles: 0,
    totalRatedArticles: 0,
    name: '',
    staticType: '',
    showStatic: false,
    categories: [],
    types: [],
    selectedType: 1,
    selectedCategory: 4,
    cache: 1,
    highlight: '',
    staticHighlight: '',
    isLoadingEmail: true,
    isLoadingSearch: false,
    isLoadingLatest: false,
    isLoadingMostRated: false,
    hasTopLeaderboard: "0",
    hasFooterLeaderboard: "0",
    hasNewsletterSubscribe: "0",
    hasSponsoredContent: "0",
    topLeaderboard: '',
    footerLeaderboard: '',
    sponsoredContent: '',
    newsletterSubscribe: ''
  };

 constructor(props) {
    super(props);
    this.timeout =  0;
    this.getTypes();
    this.getCategories();
    this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
  }


  componentDidMount = () => {
    if(this.props.emailId === undefined){
      this.setState(prevState => ({isLoadingEmail: false}))
    }
  }

  onKeyUp = (event) => {
   console.log(event);
   let searchFor = event.target.value;
   if(this.timeout) clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.setState(prevState => ({isLoadingSearch: true}))
        fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsbytype?type='+ this.state.selectedType + '&search='+ searchFor + '&cache='+ Guid.raw(), {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          }
        }).then(result => {
          this.setState(prevState => ({isLoadingSearch: false}))
         result.json().then(val => {
           console.log(val);
           this.setState(prevState => ({articles : val[0], totalArticles: val[1]}))
         }).catch(err => {
          this.setState(prevState => ({isLoadingSearch: false}))
         });
        });
    }, 300);
  }

  getEmail = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email?emailId='+ this.props.emailId + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     this.setState(prevState => ({isLoadingEmail: false}))
     result.json().then(val => {
      console.log(val);
       var s_articles = [];
       var t_articles = val.Articles1;
       var ev_articles = val.EventArticles1;
       var ed_articles = val.EditorArticles1;

       this.setState(prevState => ({ hasTopLeaderboard: val.HasTopLeaderboard, hasFooterLeaderboard: val.HasFooterLeaderboard, hasSponsoredContent: val.HasSponsoredContent, hasNewsletterSubscribe: val.HasNewsletterSubscribe}));

       this.setState(prevState => ({selectedArticles: [], selectedEventArticles: [], selectedEditorArticles: []}));
        
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

       this.setState(prevState => ({
         name: val.EmailName,
         template: val.TemplateName}));
       this.onStaticDropped();
     });
    }).catch(err => {
      this.setState(prevState => ({isLoadingEmail: false}))
    });
  }

  saveEmail = (event) => {
    event.preventDefault();
    console.dir(this.state);
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/emails', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
       name: this.state.name,
       articles: _.map(this.state.selectedArticles, article => article.ID).join(','),
       eventArticles: _.map(this.state.selectedEventArticles, article => article.ID).join(','),
       editorArticles: _.map(this.state.selectedEditorArticles, article => article.ID).join(','),
       template: this.state.template,
       content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
       hasTopLeaderboard: this.state.hasTopLeaderboard,
       hasFooterLeaderboard: this.state.hasFooterLeaderboard,
       hasSponsoredContent: this.state.hasSponsoredContent,
       hasNewsletterSubscribe: this.state.hasNewsletterSubscribe
      })
    }).then(result => {
      result.json().then(val => {
        console.log(val);
        $('.modal-backdrop').hide();
        $('body').removeClass('modal-open');
        this.props.onChangePage('Dashboard');
      });
    });
  }

  saveExistingEmail = (event) => {
    console.dir(this);
    event.preventDefault();
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
       emailId: this.props.emailId,
       articles: _.map(this.state.selectedArticles, article => article.ID).join(','),
       eventArticles: _.map(this.state.selectedEventArticles, article => article.ID).join(','),
       editorArticles: _.map(this.state.selectedEditorArticles, article => article.ID).join(','),
       template: this.state.template,
       content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
       hasTopLeaderboard: this.state.hasTopLeaderboard,
       hasFooterLeaderboard: this.state.hasFooterLeaderboard,
       hasSponsoredContent: this.state.hasSponsoredContent,
       hasNewsletterSubscribe: this.state.hasNewsletterSubscribe
      })
    }).then(result => {
      result.json().then(val => {
        console.log(val);
        $('.modal-backdrop').hide();
        $('body').removeClass('modal-open');
        this.props.onChangePage('Dashboard');
      });
    });
  }
  onNameChange = (event) => {
    this.setState({name: event.target.value});
  }

  getCategories = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/categories', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
      console.log(val);
      if(val.length > 0){
        this.setState(prevState => ({categories : val}), () => {
         this.getPosts();
         // this.getMostRatedPosts();
        })
      }
     });
    });
  }

  getTypes = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/types', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
      console.log(val);
       val.push({id: 1, name: 'All'});
       this.setState(prevState => ({types : val}))
     });
    });
  }

  setSelectedTab = (event) => {
   event.preventDefault();
   console.dir(event.target.name);
   let tab = event.target.name;
   this.setState(prevState => ({selectedTab: tab}));
   switch(tab){
    case 'Latest':
       this.getPosts();
      break;
    case 'MostRated':
       this.getMostRatedPosts();
      break;
    case 'Search':
      this.setState(prevState => ({articles : [], totalArticles: 0}))
      break;
   }
  }

  getPosts = () => {
    this.setState(prevState => ({articles : [], totalArticles: 0, isLoadingLatest: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/posts?categoryId='+ this.state.selectedCategory +'&page='+ this.state.articlePage, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
        console.log(val);
         this.setState(prevState => ({articles : val[0], totalArticles: val[1]}))
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
      this.setState(prevState => ({isLoadingLatest: false}))
     }).catch(err => {
      this.setState(prevState => ({isLoadingLatest: false}))
     });
    });
  }

  getMostRatedPosts = () => {
    this.setState(prevState => ({ratedArticles : [], totalRatedArticles: 0, isLoadingMostRated: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsmostrated?page='+ this.state.articleRatedPage, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       if(val[0].length > 0){
        console.log(val);
         this.setState(prevState => ({ratedArticles : val[0], totalRatedArticles: val[1]}))
       }
      this.setState(prevState => ({isLoadingMostRated: false}))
     }).catch(err => {
      this.setState(prevState => ({isLoadingMostRated: false}))
     });
    });
  }
  onRemoveArticle = (articleId) => {
  this.setState({selectedArticles: this.state.selectedArticles.filter(function(article) {
        return article.ID !== parseInt(articleId)
    })});
    _.each(this.state.articles, (article, index) => {
     if(article.ID === parseInt(articleId)){
      this.setState({
        articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
      })
     }
    });
  }

  onSetTemplate = (type) => {
    if(this.state.template === ''){
     alert('Please select template');
     return;
    }
    this.setState(prevState => ({
      staticType: type,
      showStatic: true
    }), () => {
      $('#slider').toggleClass('open');
      $(window).scrollTop(0);
    });
  }

  onChange = (event) => {
    const { name, value } = event.target;
    this.setState(prevState => ({
      template: value,
      selectedArticles: [],
      hasTopLeaderboard: "0",
      hasFooterLeaderboard: "0",
      hasNewsletterSubscribe: "0",
      hasSponsoredContent: "0"
    }));
  }

  onCategoryChange = (event) => {
    const { name, value } = event.target;
    console.log(value);
    this.setState(prevState => ({
      selectedCategory: value
    }), () => this.getPosts());
  }

  onTypeChange = (event) => {
    const { name, value } = event.target;
    this.setState(prevState => ({
      selectedType: value}));
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

  onNextRatedArticlePage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage + 1
    }),() => this.getMostRatedPosts());
  }

  onPrevRatedArticlePage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage - 1
    }),() => this.getMostRatedPosts());
  }
  onArticleDragged = (props) => {
   console.log(props);
   if(parseInt(this.state.selectedCategory) === 35){
    this.setState(prevState => ({highlight: 'events'}));
   }
   else if(parseInt(this.state.selectedCategory) === 45){
    this.setState(prevState => ({highlight: 'editor'}));
   }
   else{
     this.setState(prevState => ({highlight: 'articles'}));
   }
  }
  onCancelDrag = () => {
    this.setState(prevState => ({highlight: ''}));
  }
  onCancelStaticDrag = () => {
    this.setState(prevState => ({staticHighlight: ''}));
  }
  onStaticDragged = (props) => {
   console.log(props);
   if(props.name === 'Top_Leaderboard'){
    this.setState(prevState => ({staticHighlight: 'top'}));
   }
   else if(props.name === 'Footer_Leaderboard'){
    this.setState(prevState => ({staticHighlight: 'footer'}));
   }
   else if(props.name === 'Newsletter_Subscribe'){
    this.setState(prevState => ({staticHighlight: 'newsletter'}));
   }
  }
  onArticleDropped = (emailType, articleId) => {
    console.log(this.state.selectedCategory);
    this.setState(prevState => ({highlight: ''}));
    if(this.state.selectedTab === 'Latest' || this.state.selectedTab === 'Search'){
      if(parseInt(this.state.selectedCategory) === 35){
        _.each(this.state.articles, (article, index) => {
         if(article.ID === articleId){
           this.setState(prevState => ({
             selectedEventArticles: [...prevState.selectedEventArticles, article]
           }));
           this.setState({
             articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
           })
         }
        })
      }
      else if(parseInt(this.state.selectedCategory) === 45){
          _.each(this.state.articles, (article, index) => {
           if(article.ID === articleId){
             this.setState(prevState => ({
               selectedEditorArticles: [...prevState.selectedEditorArticles, article]
             }));
             this.setState({
               articles: update(this.state.articles, {[index]: {isDisabled: {$set: true}}})
             })
           }
          })
        }
      else{
        _.each(this.state.articles, (article, index) => {
         if(article.ID === articleId){
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
    else if(this.state.selectedTab === 'MostRated'){
      _.each(this.state.ratedArticles, (article, index) => {
       if(article.ID === articleId){
         this.setState(prevState => ({
           selectedArticles: [...prevState.selectedArticles, article]
         }));
         this.setState({
           ratedArticles: update(this.state.ratedArticles, {[index]: {isDisabled: {$set: true}}})
         })
       }
      })
    }
  }

  onStaticDropped = (name) => {
  console.log(name);
  if(name !== undefined){
  this.onChangeStaticStatus(name, true);
   fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ this.state.template +'&type='+ name +'&cache='+ Guid.raw(), {
     method: 'GET',
     headers: {
       'Accept': 'application/json',
       'Content-Type': 'application/json',
     }
   }).then(result => {
     result.json().then(val => {
       if(val !== null){
         console.log(val);
        _.each(val, leaderBoard => {
         switch(leaderBoard.Type){
          case 'Top_Leaderboard':
            this.setState(prevState => ({ topLeaderboard: leaderBoard.Content}));
            break;
         case 'Footer_Leaderboard':
           this.setState(prevState => ({ footerLeaderboard: leaderBoard.Content}));
           break;
         case 'Newsletter_Subscribe':
           this.setState(prevState => ({ newsletterSubscribe: leaderBoard.Content}));
           break;
         case 'Sponsored_Content':
           this.setState(prevState => ({ sponsoredContent: leaderBoard.Content}));
           break;
         }
        });
       }
     });
   }).catch(err => console.log(err));
  }
  else{
  fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ this.state.template +'&cache='+ Guid.raw(), {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    }
  }).then(result => {
    result.json().then(val => {
      if(val !== null){
        console.log(val);
        this.setState(prevState => ({ topLeaderboard: '', footerLeaderboard: '', newsletterSubscribe: '', sponsoredContent: ''}));
       _.each(val, leaderBoard => {
        switch(leaderBoard.Type){
         case 'Top_Leaderboard':
           this.setState(prevState => ({ topLeaderboard: leaderBoard.Content}));
           break;
        case 'Footer_Leaderboard':
          this.setState(prevState => ({ footerLeaderboard: leaderBoard.Content}));
          break;
        case 'Newsletter_Subscribe':
          this.setState(prevState => ({ newsletterSubscribe: leaderBoard.Content}));
          break;
        case 'Sponsored_Content':
          this.setState(prevState => ({ sponsoredContent: leaderBoard.Content}));
          break;
        }
       });
      }
    });
  }).catch(err => console.log(err));
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
    }
  }
  onChangeStaticStatus = (name, val) => {
    switch(name){
     case 'Top_Leaderboard':
       this.setState(prevState => ({ hasTopLeaderboard: val === true ? "1" : "0"}));
       break;
    case 'Footer_Leaderboard':
      this.setState(prevState => ({ hasFooterLeaderboard: val === true ? "1" : "0"}));
      break;
    case 'Newsletter_Subscribe':
      this.setState(prevState => ({ hasNewsletterSubscribe: val === true ? "1" : "0"}));
      break;
    case 'Sponsored_Content':
      this.setState(prevState => ({ hasSponsoredContent: val === true ? "1" : "0"}));
      break;
    }
  }

  onRemoveEvent = (articleId) => {
    this.setState({selectedEventArticles: this.state.selectedEventArticles.filter((article) => {
          return article.ID !== parseInt(articleId)
      })});
      _.each(this.state.articles, (article, index) => {
       if(article.ID === parseInt(articleId)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  onRemoveEditor = (articleId) => {
    this.setState({selectedEditorArticles: this.state.selectedEditorArticles.filter((article) => {
          return article.ID !== parseInt(articleId)
      })});
      _.each(this.state.articles, (article, index) => {
       if(article.ID === parseInt(articleId)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  render() {
    return (
   <div className="container">
      <div className="row">
        <div className="col-xs-6">
          <h1 className="text-center">Newsletter Builder</h1>
        </div>
        <div className="col-xs-6 email-builder-content">
          <button type="button" className="btn btn-primary pull-right" data-toggle="modal" data-target="#mdlSaveEmail">Save for later</button>
          { this.props.emailId > 0 ? <button type="button" className="btn btn-primary pull-right" onClick={this.saveExistingEmail} style={{marginRight: '5px'}}>Save</button> : ''}
          <button type="button" className="btn btn-primary pull-right action-buttons">Push to Adestra</button>
        </div>
      </div>
      <div className="row">
        <div className="col-xs-6">
          <form>
            <fieldset>
            { this.props.emailId > 0 ? <span>You are editing.</span> : <div className="form-group">
                <label htmlFor="chooseTemplate">Choose Newsletter</label>
                <select name="template" className="form-control" value={this.state.template || ''} onChange={this.onChange}>
                 {this.state.templates.map((template,key) => {
                  return <option key={key} value={template.value}>{template.name}</option>
                 })}
                </select>
              </div>}
            </fieldset>
          </form>
        </div>
      </div>
      <div className="row">
       { this.state.isLoadingEmail === true ? <div className="col-xs-8" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
        <div className="col-xs-8" id="emailContent" ref="emailContent">
           { this.state.template === 'Video_Newsletter' ? <VideoNewsLetter topLeaderboard={this.state.topLeaderboard} footerLeaderboard={this.state.footerLeaderboard} sponsoredContent={this.state.sponsoredContent} newsletterSubscribe={this.state.newsletterSubscribe} articles={this.state.selectedArticles} onRemoveArticle={this.onRemoveArticle}  highlight={this.state.highlight} staticHighlight={this.state.staticHighlight} showTopLeaderboard={this.state.hasTopLeaderboard} showFooterLeaderboard={this.state.hasFooterLeaderboard} showNewsletterSubscribe={this.state.hasNewsletterSubscribe} showSponsoredContent={this.state.hasSponsoredContent} onRemoveStatic={this.onRemoveStatic}/>  : ''}
           { this.state.template === 'Insights_Newsletter' ? <InsightsNewsLetter topLeaderboard={this.state.topLeaderboard} footerLeaderboard={this.state.footerLeaderboard} sponsoredContent={this.state.sponsoredContent} newsletterSubscribe={this.state.newsletterSubscribe} articles={this.state.selectedArticles} onRemoveArticle={this.onRemoveArticle} highlight={this.state.highlight} staticHighlight={this.state.staticHighlight} showTopLeaderboard={this.state.hasTopLeaderboard} showFooterLeaderboard={this.state.hasFooterLeaderboard} showNewsletterSubscribe={this.state.hasNewsletterSubscribe} showSponsoredContent={this.state.hasSponsoredContent} onRemoveStatic={this.onRemoveStatic}/>  : ''}
           { this.state.template === 'Digital_Magazine_Newsletter' ? <DigitalMagazineNewsLetter topLeaderboard={this.state.topLeaderboard} footerLeaderboard={this.state.footerLeaderboard} sponsoredContent={this.state.sponsoredContent} newsletterSubscribe={this.state.newsletterSubscribe} articles={this.state.selectedArticles} onRemoveArticle={this.onRemoveArticle} highlight={this.state.highlight} staticHighlight={this.state.staticHighlight} showTopLeaderboard={this.state.hasTopLeaderboard} showFooterLeaderboard={this.state.hasFooterLeaderboard} showNewsletterSubscribe={this.state.hasNewsletterSubscribe} showSponsoredContent={this.state.hasSponsoredContent} onRemoveStatic={this.onRemoveStatic}/>  : ''}
           { this.state.template === 'Breaking_News_Newsletter' ? <BreakingNewsNewsLetter topLeaderboard={this.state.topLeaderboard} footerLeaderboard={this.state.footerLeaderboard} sponsoredContent={this.state.sponsoredContent} newsletterSubscribe={this.state.newsletterSubscribe} articles={this.state.selectedArticles} onRemoveArticle={this.onRemoveArticle} highlight={this.state.highlight} staticHighlight={this.state.staticHighlight} showTopLeaderboard={this.state.hasTopLeaderboard} showFooterLeaderboard={this.state.hasFooterLeaderboard} showNewsletterSubscribe={this.state.hasNewsletterSubscribe} showSponsoredContent={this.state.hasSponsoredContent} onRemoveStatic={this.onRemoveStatic}/>  : ''}
           { this.state.template === 'Portfolio_Adviser_Newsletter' ? <PortfolioAdviserNewsLetter topLeaderboard={this.state.topLeaderboard} footerLeaderboard={this.state.footerLeaderboard} sponsoredContent={this.state.sponsoredContent} newsletterSubscribe={this.state.newsletterSubscribe} articles={this.state.selectedArticles} editorArticles={this.state.selectedEditorArticles} eventArticles={this.state.selectedEventArticles} onRemoveArticle={this.onRemoveArticle} onRemoveEvent={this.onRemoveEvent} onRemoveEditor={this.onRemoveEditor} highlight={this.state.highlight} staticHighlight={this.state.staticHighlight} showTopLeaderboard={this.state.hasTopLeaderboard} showFooterLeaderboard={this.state.hasFooterLeaderboard} showNewsletterSubscribe={this.state.hasNewsletterSubscribe} showSponsoredContent={this.state.hasSponsoredContent} onRemoveStatic={this.onRemoveStatic} />  : ''}
        </div> }
        <div className="col-xs-4 email-builder-content">
          <form>
            <fieldset>
              <div className="form-group">
                <label htmlFor="chooseContent">Choose Content</label>
                <select id="category" name="category" value={this.state.selectedCategory || ''} onChange={this.onCategoryChange} className="form-control">
                  {this.state.categories.map((category, key) => {
                   return <option key={key} value={category.id}>{category.name}</option>
                  })}
                </select>
              </div>
            </fieldset>
          </form>
          <h2>Articles</h2>
          <ul className="nav nav-tabs" id="myTabs" role="tablist">
            <li role="presentation" className="active"><a href="#latest" id="latest-tab" name="Latest" onClick={this.setSelectedTab} role="tab" data-toggle="tab" aria-controls="latest" aria-expanded="true">Latest</a></li>
            <li role="presentation" className=""><a href="#mostrated" role="tab" id="mostrated-tab" data-toggle="tab" name="MostRated" onClick={this.setSelectedTab} aria-controls="most-rated" aria-expanded="false">Most Rated</a></li>
            <li role="presentation" className=""><a href="#featuredsearch" role="tab" id="featured-search-tab" data-toggle="tab" name="Search" onClick={this.setSelectedTab} aria-controls="featured-search" aria-expanded="false">Featured Search</a></li>
          </ul>
          <div className="tab-content" id="myTabContent">
          { this.state.isLoadingLatest === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade active in" role="tabpanel" id="latest" aria-labelledby="latest-tab">
             {this.state.articles.map((article, key) => {
              return <DragArticle name={article.post_title} desc={article.post_excerpt} id={article.ID} onArticleDragged={this.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.onCancelDrag}/>
             })}
              <ul className="pager">
                <li>{this.state.articlePage > 1 ? <a href="#" onClick={this.onPrevArticlePage}>Previous</a> : ''}</li>
                <li>{this.state.articlePage < Math.ceil(this.state.totalArticles / 10) ? <a href="#" onClick={this.onNextArticlePage}>Next</a> : ''}</li>
              </ul>
            </div>}
            { this.state.isLoadingMostRated === true ? <div className="tab-pane fade" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade" role="tabpanel" id="mostrated" aria-labelledby="most-rated-tab">
            {this.state.ratedArticles.map((article, key) => {
             return <DragArticle name={article.post_title} desc={article.post_excerpt} id={article.ID} onArticleDragged={this.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCencelDrag={this.onCancelDrag}/>
            })}
            <ul className="pager">
              <li>{this.state.articleRatedPage > 1 ? <a href="#" onClick={this.onPrevRatedArticlePage}>Previous</a> : ''}</li>
              <li>{this.state.articleRatedPage < Math.ceil(this.state.totalRatedArticles / 10) ? <a href="#" onClick={this.onNextRatedArticlePage}>Next</a> : ''}</li>
            </ul>
            </div>}
            <div className="tab-pane fade" role="tabpanel" id="featuredsearch" aria-labelledby="featuredsearch">
                <div className="form-group">
                  <div className="col-sm-12">
                    <label htmlFor="article" className="control-label">Article</label>
                    <input type="text" className="form-control" id="article" placeholder="Article" onChange={this.onKeyUp}/>
                  </div>
                </div>
                <div className="form-group">
                  <div className="col-sm-12">
                    <label htmlFor="chooseCategory">Choose Category</label>
                    <select id="type" name="type" value={this.state.selectedType || ''} onChange={this.onTypeChange} className="form-control">
                     {this.state.types.map((type,key) => {
                      return <option key={key} value={type.id}>{type.name}</option>
                     })}
                    </select>
                  </div>
                </div>
                <div className="form-group">
                {this.state.isLoadingSearch === true ? <div style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : <div className="col-sm-12" style={{marginTop:'12px'}}>
                {this.state.articles.map((article, key) => {
                 return <DragArticle name={article.post_title} desc={article.post_excerpt} id={article.ID} onArticleDragged={this.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.onCancelDrag}/>
                })}
                </div>}
                </div>
            </div>
            <h2>Static Fragments</h2>
            <DragStatic id="button1" name="Newsletter_Subscribe" text="Newsletter Subscribe" onStaticDragged={this.onStaticDragged} onCancelStaticDrag={this.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Newsletter_Subscribe')}/>
            <DragStatic id="button2" name="Sponsored_Content" text="Sponsored Content" onStaticDragged={this.onStaticDragged} onCancelStaticDrag={this.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content')}/>
            <DragStatic id="button3" name="Top_Leaderboard" text="Top Leaderboard" onStaticDragged={this.onStaticDragged} onCancelStaticDrag={this.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard')}/>
            <DragStatic id="button4" name="Footer_Leaderboard" text="Footer Leaderboard" onStaticDragged={this.onStaticDragged} onCancelStaticDrag={this.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard')}/>
          </div>
        </div>
      </div>
      <div id="mdlSaveEmail" className="modal fade" role="dialog" ref="modal">
        <div className="modal-dialog">
          <div className="modal-content">
           <form onSubmit={this.saveEmail}>
            <div className="modal-header">
              <button type="button" className="close" data-dismiss="modal" onClick={() => $('body').removeClass('modal-open')}>&times;</button>
              <h4 className="modal-title">Save Email</h4>
            </div>
            <div className="modal-body">
               <div className="form-group">
                <label htmlFor="pwd">Name:</label>
                <input type="text" className="form-control" id="pwd" onChange={this.onNameChange}/>
              </div>
            </div>
            <div className="modal-footer">
              <button type="submit" className="btn btn-default">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      {this.state.showStatic === true ? <CreateStatic type={this.state.staticType} template={this.state.template} showStatic={this.state.showStatic}/> : ''}
    </div>
    );
  }
}

export default CreateEmail;
