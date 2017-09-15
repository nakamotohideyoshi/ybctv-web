import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { DragDropContext } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';
import update from 'react-addons-update';
import VideoNewsLetter from './VideoNewsLetter';
import InsightsNewsLetter from './InsightsNewsLetter';
import ChinaInsightsNewsLetter from './ChinaInsightsNewsLetter';
import DigitalMagazineNewsLetter from './DigitalMagazineNewsLetter';
import BreakingNewsNewsLetter from './BreakingNewsNewsLetter';
import PortfolioAdviserNewsLetter from './PortfolioAdviserNewsLetter';
import DragArticle from './DragArticle';
import DragStatic from './DragStatic';
import CreateStatic from './CreateStatic';
import '../node_modules/font-awesome/css/font-awesome.css';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';

class CreateEmail extends Component {
  state = { 
      templates: [{name: '-- Select Email Newsletter --'},
                {name: 'Portfolio Adviser Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_2_'},
                {name: 'International Adviser Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_3_'},
                {name: 'Fund Selector Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_4_'},
                {name: 'Expert Investor Europe Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_5_'},
                {name: 'Breaking News Newsletter', value: 'Breaking_News_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'},
                {name: 'Digital Magazine Newsletter', value: 'Digital_Magazine_Newsletter', sites: 'wp_2_,wp_3_,wp_5_'},
                {name: 'Insights Newsletter', value: 'Insights_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'},
                {name: 'China Insights Newsletter', value: 'China_Insights_Newsletter',sites: 'wp_4_'},
                {name: 'Video Newsletter', value: 'Video_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'}],
      otherStories: [{name: '-- Select Other Story --'},
                     {name: 'Expert Investor Advisor', sites: 'wp_2_,wp_3_,wp_4_',value: 'wp_5_'},
                     {name: 'Fund Selector Asia', sites: 'wp_2_,wp_3_,wp_5_', value: 'wp_4_'},
                     {name: 'International Advisor', sites: 'wp_2_,wp_4_,wp_5_', value: 'wp_3_'},
                     {name: 'Portfolio Advisor', sites: 'wp_3_,wp_4_,wp_5_', value: 'wp_2_'}],
    otherStory: '',
    template: '',
    selectedTab: 'Latest',
    articleRatedPage: 1,
    name: '',
    staticType: '',
    showStatic: false,
  };

 constructor(props) {
    super(props);
    this.timeout =  0;
    this.props.getTypes();
    this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
    this.props.getCategories(() => {
      this.props.getPosts();
    });
  }


  componentDidMount = () => {
    if(this.props.emailId === undefined){
      this.props.onLoadingEmail(false);
    }
  }

  onKeyUp = (event) => {
   console.log(event);
   let searchFor = event.target.value;
   if(this.timeout) clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.props.getPostsByType(this.state.selectedType, searchFor);
    }, 300);
  }

  onStoryKeyUp = (event) => {
   console.log(event);
   let searchFor = event.target.value;
   if(this.timeout) clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.props.getPostsBySite(this.state.otherStory, searchFor);
    }, 300);
  }

  getEmail = () => {
    this.props.getEmail((emailName, templateName) => {
      this.onStaticDropped();
      this.setState(prevState => ({
        name: emailName,
        template: templateName}));
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
       articles: _.map(this.props.selectedArticles, article => article.ID).join(','),
       eventArticles: _.map(this.props.selectedEventArticles, article => article.ID).join(','),
       editorArticles: _.map(this.props.selectedEditorArticles, article => article.ID).join(','),
       template: this.state.template,
       content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
       hasTopLeaderboard: this.state.hasTopLeaderboard,
       hasFooterLeaderboard: this.state.hasFooterLeaderboard,
       hasSponsoredContent: this.state.hasSponsoredContent,
       hasNewsletterSubscribe: this.state.hasNewsletterSubscribe,
       prefix: this.props.site
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

  pushToAdestra = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email?emailId='+ this.props.emailId + '&prefix='+ this.props.site +'&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     this.setState(prevState => ({isLoadingEmail: false}))
     result.json().then(val => {
      console.log(val);
      var project_id = 0;
      switch(this.props.site){
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
      }
      var content = '<!doctype html>\
                  <html lang="en">\
                  <head>\
                  <meta charset="utf-8">\
                   <title>Last Word Emails</title>\
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">\
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>\
                    <style>\
                      h1 {\
                        color: #ffffff;\
                        margin-left: 10px;\
                       }\
                    </style>\
                   <body>\
                   '+ val.Content +'\
                   </body>\
               </html>';

      // content = content.replace(/<img src="(.*?)cross.png"(.*?)\/?>/mg, "");
      console.log(content);
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/adestra', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
         project_id: project_id,
         content: content
        })
      }).then(result => {
        result.json().then(val => {
          console.log(val);
          this.props.onChangePage('Dashboard');
        });
      });
     });
    }).catch(err => {
      this.setState(prevState => ({isLoadingEmail: false}))
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
       articles: _.map(this.props.selectedArticles, article => article.ID).join(','),
       eventArticles: _.map(this.props.selectedEventArticles, article => article.ID).join(','),
       editorArticles: _.map(this.props.selectedEditorArticles, article => article.ID).join(','),
       template: this.state.template,
       content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
       hasTopLeaderboard: this.state.hasTopLeaderboard,
       hasFooterLeaderboard: this.state.hasFooterLeaderboard,
       hasSponsoredContent: this.state.hasSponsoredContent,
       hasNewsletterSubscribe: this.state.hasNewsletterSubscribe,
       prefix: this.props.site
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



  setSelectedTab = (event) => {
   event.preventDefault();
   console.dir(event.target.name);
   let tab = event.target.name;
   this.setState(prevState => ({selectedTab: tab}));
   switch(tab){
    case 'Latest':
       this.props.getPosts();
      break;
    case 'MostRated':
       this.props.getMostRatedPosts();
      break;
    case 'Search':
      this.props.resetArticles();
      break;
   }
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
    this.setState({
      template: value,
    });
    this.props.onChangeTemplate();
  }

  onCategoryChange = (event) => {
    const { name, value } = event.target;
    console.log(value);
    this.props.onCategoryChange(value);
  }

  onOtherStoryChange = (event) => {
    const { name, value } = event.target;
    this.setState(prevState => ({
      otherStory: value}));
  }

  onTypeChange = (event) => {
    const { name, value } = event.target;
    this.setState(prevState => ({
      selectedType: value}));
  }

  onNextRatedArticlePage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage + 1
    }),() => this.props.getMostRatedPosts());
  }

  onPrevRatedArticlePage = () => {
    this.setState(prevState => ({
      articleRatedPage: this.state.articleRatedPage - 1
    }),() => this.props.getMostRatedPosts());
  }
  onArticleDropped = (emailType, articleId, type) => {
    this.props.onArticleDropped(emailType, articleId, this.state.selectedTab, type);
  }

  onStaticDropped = (name) => {
  console.log(name);
  this.props.onStaticDropped(name, this.state.template);
  }

  onChangeStaticStatus = (name, val) => {
    this.props.onChangeStaticStatus(name, val);
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
          <button type="button" className="btn btn-primary pull-right action-buttons" onClick={this.pushToAdestra}>Push to Adestra</button>
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
                   if((template.sites !== undefined && template.sites.split(',').indexOf(this.props.site) >= 0) || template.sites === undefined)
                  return <option key={key} value={template.value}>{template.name}</option>
                 })}
                </select>
              </div>}
            </fieldset>
          </form>
        </div>
      </div>
      <div className="row">
       { this.props.isLoadingEmail === true ? <div className="col-xs-8" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
        <div className="col-xs-8" id="emailContent" ref="emailContent">
           { this.state.template === 'Video_Newsletter' ? <VideoNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle}  highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles}/>  : ''}
           { this.state.template === 'Insights_Newsletter' ? <InsightsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles}/>  : ''}
           { this.state.template === 'Digital_Magazine_Newsletter' ? <DigitalMagazineNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles}/>  : ''}
           { this.state.template === 'Breaking_News_Newsletter' ? <BreakingNewsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles}/>  : ''}
           { this.state.template === 'Portfolio_Adviser_Newsletter' ? <PortfolioAdviserNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} editorArticles={this.props.selectedEditorArticles} eventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} />  : ''}
           { this.state.template === 'China_Insights_Newsletter' ? <ChinaInsightsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} editorArticles={this.props.selectedEditorArticles} eventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} />  : ''}
        </div> }
        <div className="col-xs-4 email-builder-content">
          <form>
            <fieldset>
              <div className="form-group">
                <label htmlFor="chooseContent">Choose Content</label>
                { this.props.isLoadingCategories === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
                <select id="category" name="category" value={this.props.selectedCategory || ''} onChange={this.onCategoryChange} className="form-control">
                  {this.props.categories.map((category, key) => {
                   return <option key={key} value={category.id}>{category.name}</option>
                  })}
                </select>}
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
          { this.props.isLoadingLatest === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade active in" role="tabpanel" id="latest" aria-labelledby="latest-tab">
             {this.props.articles.map((article, key) => {
              return <DragArticle name={article.post_title} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
             })}
              <ul className="pager">
                <li>{this.props.articlePage > 1 ? <a href="#" onClick={this.props.onPrevArticlePage}>Previous</a> : ''}</li>
                <li>{this.props.articlePage < Math.ceil(this.props.totalArticles / 10) ? <a href="#" onClick={this.props.onNextArticlePage}>Next</a> : ''}</li>
              </ul>
            </div>}
            { this.props.isLoadingMostRated === true ? <div className="tab-pane fade" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade" role="tabpanel" id="mostrated" aria-labelledby="most-rated-tab">
            {this.props.ratedArticles.map((article, key) => {
             return <DragArticle name={article.post_title} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
            })}
            <ul className="pager">
              <li>{this.state.articleRatedPage > 1 ? <a href="#" onClick={this.onPrevRatedArticlePage}>Previous</a> : ''}</li>
              <li>{this.state.articleRatedPage < Math.ceil(this.props.totalRatedArticles / 10) ? <a href="#" onClick={this.onNextRatedArticlePage}>Next</a> : ''}</li>
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
                     {this.props.types.map((type,key) => {
                      return <option key={key} value={type.id}>{type.name}</option>
                     })}
                    </select>
                  </div>
                </div>
                <div className="form-group">
                {this.props.isLoadingSearch === true ? <div style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : <div className="col-sm-12" style={{marginTop:'12px'}}>
                {this.props.articles.map((article, key) => {
                 return <DragArticle name={article.post_title} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
                })}
                </div>}
                </div>
            </div>
            <h2>Static Fragments</h2>
            <DragStatic id="button1" name="Newsletter_Subscribe" text="Newsletter Subscribe" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Newsletter_Subscribe')}/>
            <DragStatic id="button2" name="Sponsored_Content" text="Sponsored Content" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content')}/>
            <DragStatic id="button3" name="Top_Leaderboard" text="Top Leaderboard" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard')}/>
            <DragStatic id="button4" name="Footer_Leaderboard" text="Footer Leaderboard" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard')}/>
            <div className="form-group">
              <label htmlFor="chooseContent">Latest Articles</label>
              <select id="latestArticles" name="latestArticles" value={this.state.otherStory || ''} onChange={this.onOtherStoryChange} className="form-control">
                {this.state.otherStories.map((story, key) => {
                  if((story.sites !== undefined && story.sites.split(',').indexOf(this.props.site) >= 0) || story.sites === undefined)
                 return <option key={key} value={story.value}>{story.name}</option>
                })}
              </select>
              <div className="form-group">
                <div className="col-sm-12">
                  <label htmlFor="article" className="control-label">Article</label>
                  <input type="text" className="form-control" id="story" placeholder="Article" onChange={this.onStoryKeyUp}/>
                </div>
              </div>
              {this.props.isLoadingStory === true ? <div style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : <div className="col-sm-12" style={{marginTop:'12px'}}>
                {this.props.otherArticles.map((article, key) => {
                 return <DragArticle name={article.post_title} type={this.state.otherStory} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
                })}
                </div>}
            </div>
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
      {this.state.showStatic === true ? <CreateStatic type={this.state.staticType} template={this.state.template} showStatic={this.state.showStatic} site={this.props.site}/> : ''}
    </div>
    );
  }
}

export default DragDropContext(HTML5Backend)(CreateEmail);
