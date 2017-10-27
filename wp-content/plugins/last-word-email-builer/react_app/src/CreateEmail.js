import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { DragDropContext } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';
import update from 'react-addons-update';
import VideoNewsLetter from './VideoNewsLetter';
import InsightsNewsLetter from './InsightsNewsLetter';
import ChinaInsightsNewsLetter from './ChinaInsightsNewsLetter';
import AllBlocksNewsLetter from './AllBlocksNewsLetter';
import DigitalMagazineNewsLetter from './DigitalMagazineNewsLetter';
import BreakingNewsNewsLetter from './BreakingNewsNewsLetter';
import PortfolioAdviserNewsLetter from './PortfolioAdviserNewsLetter';
import PortfolioAdviserInvestmentNewsLetter from './PortfolioAdviserInvestmentNewsLetter';
import PortfolioAdviserMRInvestmentNewsLetter from './PortfolioAdviserMRInvestmentNewsLetter';
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
                {name: 'International Adviser Newsletter', value: 'Portfolio_Adviser_Newsletter_Investment', sites: 'wp_3_'},
                {name: 'International Adviser Newsletter Most Read', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_3_'},
                {name: 'International Adviser Newsletter MR Investment', value: 'Portfolio_Adviser_MR_Newsletter', sites: 'wp_3_'},
                {name: 'Fund Selector Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_4_'},
                {name: 'Expert Investor Europe Newsletter', value: 'Portfolio_Adviser_Newsletter', sites: 'wp_5_'},
                {name: 'Breaking News Newsletter', value: 'Breaking_News_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'},
                {name: 'Digital Magazine Newsletter', value: 'Digital_Magazine_Newsletter', sites: 'wp_2_,wp_3_,wp_5_'},
                {name: 'Insights Newsletter', value: 'Insights_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'},
                {name: 'China Insights Newsletter', value: 'China_Insights_Newsletter',sites: 'wp_4_'},
                {name: 'All Blocks Newsletter', value: 'All_Blocks_Newsletter',sites: 'wp_4_'},
                {name: 'Video Newsletter', value: 'Video_Newsletter',sites: 'wp_2_,wp_3_,wp_4_,wp_5_'}],
      otherStories: [{name: '-- Select Other Story --'},
                     {name: 'Expert Investor Advisor', sites: 'wp_2_,wp_3_,wp_4_',value: 'wp_5_'},
                     {name: 'Fund Selector Asia', sites: 'wp_2_,wp_3_,wp_5_', value: 'wp_4_'},
                     {name: 'International Advisor', sites: 'wp_2_,wp_4_,wp_5_', value: 'wp_3_'},
                     {name: 'Portfolio Advisor', sites: 'wp_3_,wp_4_,wp_5_', value: 'wp_2_'}],
    otherStory: '',
    template: '',
    name: '',
    subject: '',
    staticType: '',
    showStatic: false,
  };

  onCloseStatic = () => {
    this.setState({showStatic: false});
  }

 constructor(props) {
    super(props);
    this.timeout =  0;
    this.props.getTypes();
    this.props.emailId > 0 ? this.getEmail() : '';
    this.props.getCategories(() => {
      this.props.getPosts();
    });
    this.props.getLatestPostsBySite();
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
      this.props.getPostsByType(this.props.selectedType, searchFor);
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

  onEventKeyUp = (event) => {
   console.log(event);
   let searchFor = event.target.value;
   if(this.timeout) clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.props.getPostsByEvent(searchFor);
    }, 300);
  }

  getEmail = () => {
    this.props.getEmail((emailName, templateName) => {
      this.setState(prevState => ({
        name: emailName,
        template: templateName}), () => {
          this.onStaticDropped();
        });
    });
  }

  saveEmail = (event) => {
    event.preventDefault();
    console.dir(this.state);
    $(".cross-img").remove();
    let body = {
      name: this.state.name,
      subject: this.state.subject,
      articles: _.map(this.props.selectedArticles, article => article.ID).join(','),
      eventArticles: _.map(this.props.selectedEventArticles, article => article.ID).join(','),
      editorArticles: _.map(this.props.selectedEditorArticles, article => article.ID).join(','),
      mostViewedArticles: _.map(this.props.selectedMostViewedArticles, article => article.ID).join(','),
      moreNewsArticles: _.map(this.props.selectedMoreNewsArticles, article => article.ID).join(','),
      mostReadArticles: _.map(this.props.selectedMostReadArticles, article => article.ID).join(','),
      investmentArticles: _.map(this.props.selectedInvestmentArticles, article => article.ID).join(','),
      template: this.state.template,
      content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
      hasTopLeaderboard: this.props.hasTopLeaderboard === null || this.props.hasTopLeaderboard === "0" ? "0" : "1",
      hasFooterLeaderboard: this.props.hasFooterLeaderboard === null || this.props.hasFooterLeaderboard === "0" ? "0" : "1",
      hasSponsoredContent: this.props.hasSponsoredContent === null || this.props.hasSponsoredContent === "0" ? "0" : "1",
      hasSponsoredContent2: this.props.hasSponsoredContent2 === null || this.props.hasSponsoredContent2 === "0" ? "0" : "1",
      hasNewsletterSubscribe: this.props.hasNewsletterSubscribe === null || this.props.hasNewsletterSubscribe === "0" ? "0" : "1",
      hasStaticImage1: this.props.hasStaticImage1 === null || this.props.hasStaticImage1 === "0" ? "0" : "1",
      hasStaticImage2: this.props.hasStaticImage2 === null || this.props.hasStaticImage2 === "0" ? "0" : "1",
      hasAssetClass: this.props.hasAssetClass === null || this.props.hasAssetClass === "0" ? "0" : "1",
      hasQuotable: this.props.hasQuotable === null || this.props.hasQuotable === "0" ? "0" : "1",
      prefix: this.props.site
    }
    console.log(body);
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/emails', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(body)
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
    this.props.pushToAdestra();
  }

  saveExistingEmail = (event) => {
    console.dir(this);
    event.preventDefault();
    $(".cross-img").remove();
    let body = {
      emailId: this.props.emailId,
      articles: _.map(this.props.selectedArticles, article => article.ID).join(','),
      eventArticles: _.map(this.props.selectedEventArticles, article => article.ID).join(','),
      editorArticles: _.map(this.props.selectedEditorArticles, article => article.ID).join(','),
      mostViewedArticles: _.map(this.props.selectedMostViewedArticles, article => article.ID).join(','),
      mostReadArticles: _.map(this.props.selectedMostReadArticles, article => article.ID).join(','),
      investmentArticles: _.map(this.props.selectedInvestmentArticles, article => article.ID).join(','),
      moreNewsArticles: _.map(this.props.selectedMoreNewsArticles, article => article.ID).join(','),
      template: this.state.template,
      content: ReactDOM.findDOMNode(this.refs.emailContent).innerHTML,
      hasTopLeaderboard: this.props.hasTopLeaderboard === null || this.props.hasTopLeaderboard === "0" ? "0" : "1",
      hasFooterLeaderboard: this.props.hasFooterLeaderboard === null || this.props.hasFooterLeaderboard === "0" ? "0": "1",
      hasSponsoredContent: this.props.hasSponsoredContent === null || this.props.hasSponsoredContent === "0" ? "0": "1",
      hasSponsoredContent2: this.props.hasSponsoredContent2 === null || this.props.hasSponsoredContent2 === "0" ? "0": "1",
      hasNewsletterSubscribe: this.props.hasNewsletterSubscribe === null || this.props.hasNewsletterSubscribe === "0" ? "0": "1",
      hasStaticImage1: this.props.hasStaticImage1 === null || this.props.hasStaticImage1 === "0" ? "0" : "1",
      hasStaticImage2: this.props.hasStaticImage2 === null || this.props.hasStaticImage2 === "0" ? "0" : "1",
      hasAssetClass: this.props.hasAssetClass === null || this.props.hasAssetClass === "0" ? "0" : "1",
      hasQuotable: this.props.hasQuotable === null || this.props.hasQuotable === "0" ? "0" : "1",
      prefix: this.props.site
    }
    console.log(body);
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(body)
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

  onSubjectChange = (event) => {
    this.setState({subject: event.target.value});
  }


  setSelectedTab = (event) => {
   event.preventDefault();
   console.dir(event.target.name);
   let tab = event.target.name;
   this.props.setSelectedTab(tab);
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
    this.props.onTypeChange(value);
  }

  onNextRatedArticlePage = () => {
    this.props.onNextRatedArticlePage();
  }

  onPrevRatedArticlePage = () => {
    this.props.onPrevRatedArticlePage();
  }
  onArticleDropped = (emailType, articleId, type) => {
    this.props.onArticleDropped(emailType, articleId, this.props.selectedTab, type);
  }

  onStaticDropped = (name) => {
  console.log(name, this.state.template);
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
          { this.props.emailId > 0 ? <button type="button" className="btn btn-primary pull-right action-buttons" onClick={this.pushToAdestra}>Push to Adestra</button> : ''}
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
           { this.state.template === 'Video_Newsletter' ? <VideoNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle}  highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped}/>  : ''}
           { this.state.template === 'Insights_Newsletter' ? <InsightsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} insights={this.props.insights} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped}/>  : ''}
           { this.state.template === 'Digital_Magazine_Newsletter' ? <DigitalMagazineNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} digitalMagazine={this.props.digitalMagazine} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped}/>  : ''}
           { this.state.template === 'Breaking_News_Newsletter' ? <BreakingNewsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} onRemoveArticle={this.props.onRemoveArticle} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped}/>  : ''}
           { this.state.template === 'Portfolio_Adviser_Newsletter' ? <PortfolioAdviserNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} selectedEditorArticles={this.props.selectedEditorArticles} selectedEventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} selectedInvestmentArticles={this.props.selectedInvestmentArticles} selectedMostReadArticles={this.props.selectedMostReadArticles} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped} />  : ''}
           { this.state.template === 'Portfolio_Adviser_Newsletter_Investment' ? <PortfolioAdviserInvestmentNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} selectedEditorArticles={this.props.selectedEditorArticles} selectedEventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} selectedInvestmentArticles={this.props.selectedInvestmentArticles} selectedMostReadArticles={this.props.selectedMostReadArticles} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped} />  : ''}
           { this.state.template === 'Portfolio_Adviser_MR_Newsletter' ? <PortfolioAdviserMRInvestmentNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} selectedEditorArticles={this.props.selectedEditorArticles} selectedEventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} selectedInvestmentArticles={this.props.selectedInvestmentArticles} selectedMostReadArticles={this.props.selectedMostReadArticles} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped} />  : ''}
           { this.state.template === 'China_Insights_Newsletter' ? <ChinaInsightsNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} staticImage1={this.props.staticImage1} staticImage2={this.props.staticImage2} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} selectedEditorArticles={this.props.selectedEditorArticles} showStaticImage1={this.props.hasStaticImage1} showStaticImage2={this.props.hasStaticImage2} selectedEventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped} selectedMoreNewsArticles={this.props.selectedMoreNewsArticles}/>  : ''}
           { this.state.template === 'All_Blocks_Newsletter' ? <AllBlocksNewsLetter topLeaderboard={this.props.topLeaderboard} footerLeaderboard={this.props.footerLeaderboard} assetClass={this.props.assetClass} quotable={this.props.quotable} staticImage1={this.props.staticImage1} staticImage2={this.props.staticImage2} sponsoredContent2={this.props.sponsoredContent2} sponsoredContent={this.props.sponsoredContent} showQuotable={this.props.hasQuotable} showAssetClass={this.props.hasAssetClass} showStaticImage1={this.props.hasStaticImage1} showStaticImage2={this.props.hasStaticImage2} newsletterSubscribe={this.props.newsletterSubscribe} articles={this.props.selectedArticles} selectedEditorArticles={this.props.selectedEditorArticles} selectedMostViewedArticles={this.props.selectedMostViewedArticles} selectedEventArticles={this.props.selectedEventArticles} onRemoveArticle={this.props.onRemoveArticle} onRemoveEvent={this.props.onRemoveEvent} onRemoveEditor={this.props.onRemoveEditor} highlight={this.props.highlight} staticHighlight={this.props.staticHighlight} showTopLeaderboard={this.props.hasTopLeaderboard} showFooterLeaderboard={this.props.hasFooterLeaderboard} showNewsletterSubscribe={this.props.hasNewsletterSubscribe} showSponsoredContent2={this.props.hasSponsoredContent2} showSponsoredContent={this.props.hasSponsoredContent} onRemoveStatic={this.props.onRemoveStatic} site={this.props.site} selectedStoryArticles={this.props.selectedStoryArticles} onArticleDropped={this.props.onArticleDropped} selectedMoreNewsArticles={this.props.selectedMoreNewsArticles}/>  : ''}
        </div> }
        <div className="col-xs-4 email-builder-content">

<div className="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div className="panel panel-default">
    <div className="panel-heading" role="tab" id="headingOne">
      <h4 className="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Website Articles
        </a>
      </h4>
    </div>
    <div id="collapseOne" className="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div className="panel-body">

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
            <li role="presentation" className="active"><a href="#latest" id="latest-tab" ref="latestTab" name="Latest" onClick={this.setSelectedTab} role="tab" data-toggle="tab" aria-controls="latest" aria-expanded="true">Latest</a></li>
            <li role="presentation" className=""><a href="#mostrated" role="tab" id="mostrated-tab" data-toggle="tab" name="MostRated" onClick={this.setSelectedTab} aria-controls="most-rated" aria-expanded="false">Most Read</a></li>
            <li role="presentation" className=""><a href="#featuredsearch" role="tab" id="featured-search-tab" data-toggle="tab" name="Search" onClick={this.setSelectedTab} aria-controls="featured-search" aria-expanded="false">Featured Search</a></li>
          </ul>
          <div className="tab-content" id="myTabContent">
          { this.props.isLoadingLatest === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade active in" role="tabpanel" id="latest" aria-labelledby="latest-tab">
             {this.props.articles.map((article, key) => {
              return <DragArticle type="article" name={article.post_title} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
             })}
              <ul className="pager">
                <li>{this.props.articlePage > 1 ? <a href="#" onClick={this.props.onPrevArticlePage}>Previous</a> : ''}</li>
                <li>{this.props.articlePage < Math.ceil(this.props.totalArticles / 10) ? <a href="#" onClick={this.props.onNextArticlePage}>Next</a> : ''}</li>
              </ul>
            </div>}
            { this.props.isLoadingMostRated === true ? <div className="tab-pane fade" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
            <div className="tab-pane fade" role="tabpanel" id="mostrated" aria-labelledby="most-rated-tab">
            {this.props.ratedArticles.map((article, key) => {
             return <DragArticle type="rated" name={article.post_title} desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
            })}
            <ul className="pager">
              <li>{this.props.articleRatedPage > 1 ? <a href="#" onClick={this.onPrevRatedArticlePage}>Previous</a> : ''}</li>
              <li>{this.props.articleRatedPage < Math.ceil(this.props.totalRatedArticles / 10) ? <a href="#" onClick={this.onNextRatedArticlePage}>Next</a> : ''}</li>
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
                    <select id="type" name="type" value={this.props.selectedType || ''} onChange={this.onTypeChange} className="form-control">
                     {this.props.types.map((type,key) => {
                      return <option key={key} value={type.id}>{type.name}</option>
                     })}
                    </select>
                  </div>
                </div>
                <div className="form-group">
                {this.props.isLoadingSearch === true ? <div style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : <div className="col-sm-12" style={{marginTop:'12px'}}>
                {this.props.articles.map((article, key) => {
                 return <DragArticle name={article.post_title.substring(0, 30)} type="article" desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
                })}
                </div>}
                </div>
            </div>

            </div>
            </div>
            </div>
            </div>
 <div className="panel panel-default">
    <div className="panel-heading" role="tab" id="headingTwo">
      <h4 className="panel-title">
        <a className="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Static Fragments
        </a>
      </h4>
    </div>
    <div id="collapseTwo" className="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div className="panel-body">
            <DragStatic id="button1" name="Newsletter_Subscribe" text="Newsletter Subscribe" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Newsletter_Subscribe')} isDisabled={this.props.hasNewsletterSubscribe === "0" ? true : false}/>
            <hr/>
            <DragStatic id="button2" name="Digital_Magazine" text="Digital Magazine" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Digital_Magazine')} isDisabled={true}/>
            <DragStatic id="button3" name="Digital_Magazine_2" text="Digital Magazine 2" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Digital_Magazine_2')} isDisabled={true}/>
            <hr/>
            <DragStatic id="button4" name="Sponsored_Content" text="Sponsored Content A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <DragStatic id="button5" name="Sponsored_Content_b" text="Sponsored Content B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_b')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <DragStatic id="button6" name="Sponsored_Content_c" text="Sponsored Content C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_c')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <DragStatic id="button7" name="Sponsored_Content_d" text="Sponsored Content D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_d')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <DragStatic id="button8" name="Sponsored_Content_e" text="Sponsored Content E" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_e')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <DragStatic id="button9" name="Sponsored_Content_f" text="Sponsored Content F" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_f')} isDisabled={this.props.hasSponsoredContent === "0" ? true : false}/>
            <hr/>
            <DragStatic id="button10" name="Sponsored_Content_2" text="Sponsored Content 2A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <DragStatic id="button11" name="Sponsored_Content_2b" text="Sponsored Content 2B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2b')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <DragStatic id="button12" name="Sponsored_Content_2c" text="Sponsored Content 2C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2c')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <DragStatic id="button13" name="Sponsored_Content_2d" text="Sponsored Content 2D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2d')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <DragStatic id="button14" name="Sponsored_Content_2e" text="Sponsored Content 2E" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2e')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <DragStatic id="button15" name="Sponsored_Content_2f" text="Sponsored Content 2F" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Sponsored_Content_2f')} isDisabled={this.props.hasSponsoredContent2 === "0" ? true : false}/>
            <hr/>
            <DragStatic id="button16" name="Top_Leaderboard" text="Top Leaderboard A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <DragStatic id="button17" name="Top_Leaderboard_b" text="Top Leaderboard B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard_b')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <DragStatic id="button18" name="Top_Leaderboard_c" text="Top Leaderboard C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard_c')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <DragStatic id="button19" name="Top_Leaderboard_d" text="Top Leaderboard D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard_d')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <DragStatic id="button20" name="Top_Leaderboard_e" text="Top Leaderboard E" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard_e')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <DragStatic id="button21" name="Top_Leaderboard_f" text="Top Leaderboard F" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Top_Leaderboard_f')} isDisabled={this.props.hasTopLeaderboard === "0" ? true : false}/>
            <hr/>
            <DragStatic id="button22" name="Footer_Leaderboard" text="Footer Leaderboard A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <DragStatic id="button23" name="Footer_Leaderboard_b" text="Footer Leaderboard B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard_b')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <DragStatic id="button24" name="Footer_Leaderboard_c" text="Footer Leaderboard C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard_c')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <DragStatic id="button25" name="Footer_Leaderboard_d" text="Footer Leaderboard D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard_d')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <DragStatic id="button26" name="Footer_Leaderboard_e" text="Footer Leaderboard E" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard_e')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <DragStatic id="button27" name="Footer_Leaderboard_f" text="Footer Leaderboard F" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Footer_Leaderboard_f')} isDisabled={this.props.hasFooterLeaderboard === "0" ? true : false}/>
            <hr/>
            <DragStatic id="button28" name="Static_Image_1" text="Static Image 1A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_1')} isDisabled={this.props.hasStaticImage1 === "0" ? true : false}/>
            { this.props.site == 'wp_4_' ? <DragStatic id="button29" name="Static_Image_1b" text="Static Image 1B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_1b')} isDisabled={this.props.hasStaticImage1 === "0" ? true : false}/> : null }
            { this.props.site == 'wp_4_' ? <DragStatic id="button30" name="Static_Image_1c" text="Static Image 1C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_1c')} isDisabled={this.props.hasStaticImage1 === "0" ? true : false}/> : null }
            { this.props.site == 'wp_4_' ? <DragStatic id="button31" name="Static_Image_1d" text="Static Image 1D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_1d')} isDisabled={this.props.hasStaticImage1 === "0" ? true : false}/> : null }
            <hr/>
            <DragStatic id="button32" name="Static_Image_2" text="Static Image 2A" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_2')} isDisabled={this.props.hasStaticImage2 === "0" ? true : false}/>
            { this.props.site == 'wp_4_' ? <DragStatic id="button33" name="Static_Image_2b" text="Static Image 2B" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_2b')} isDisabled={this.props.hasStaticImage2 === "0" ? true : false}/> : null }
            { this.props.site == 'wp_4_' ? <DragStatic id="button34" name="Static_Image_2c" text="Static Image 2C" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_2c')} isDisabled={this.props.hasStaticImage2 === "0" ? true : false}/> : null }
            { this.props.site == 'wp_4_' ? <DragStatic id="button35" name="Static_Image_2d" text="Static Image 2D" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Static_Image_2d')} isDisabled={this.props.hasStaticImage2 === "0" ? true : true}/> : null }
            <hr/>
            <DragStatic id="button36" name="Asset_Class" text="Asset Class" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Asset_Class')} isDisabled={this.props.hasAssetClass === "0" ? true : false}/>
            <DragStatic id="button37" name="Quotable" text="Quotable" onStaticDragged={this.props.onStaticDragged} onCancelStaticDrag={this.props.onCancelStaticDrag} onStaticDropped={this.onStaticDropped} onClick={() => this.onSetTemplate('Quotable')} isDisabled={this.props.hasQuotable === "0" ? true : false}/>
      </div>
    </div>
   </div>
      <div className="panel panel-default">
          <div className="panel-heading" role="tab" id="headingFour">
            <h4 className="panel-title">
              <a className="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Events
              </a>
            </h4>
          </div>
          <div id="collapseFour" className="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" >
            <div className="panel-body">
            <div className="form-group">
                <label htmlFor="event" className="control-label">Event</label>
                <input type="text" className="form-control" id="story" placeholder="Event" onChange={this.onEventKeyUp}/>
            </div>
            {this.props.isLoadingEvents === true ? <div style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : <div className="col-sm-12" style={{marginTop:'12px'}}>
              {this.props.eventArticles.map((article, key) => {
               return <DragArticle name={article.post_title} type="event" desc={article.post_excerpt} id={parseInt(article.ID)} onArticleDragged={this.props.onArticleDragged} onArticleDropped={this.onArticleDropped} isDisabled={article.isDisabled} key={key} onCancelDrag={this.props.onCancelDrag}/>
              })}
              </div>}
            </div>
          </div>
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
                <input type="text" className="form-control" id="name" onChange={this.onNameChange}/>
              </div>
              <div className="form-group">
               <label htmlFor="pwd">Subject:</label>
               <input type="text" className="form-control" id="subject" onChange={this.onSubjectChange}/>
             </div>
            </div>
            <div className="modal-footer">
              <button type="submit" className="btn btn-default">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      {this.state.showStatic === true ? <CreateStatic type={this.state.staticType} template={this.state.template} showStatic={this.state.showStatic} site={this.props.site} onCloseStatic={this.onCloseStatic}/> : ''}
    </div>
    );
  }
}

export default DragDropContext(HTML5Backend)(CreateEmail);
