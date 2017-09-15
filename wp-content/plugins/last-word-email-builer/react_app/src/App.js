import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import Header from './Header';
import update from 'react-addons-update';
import PropTypes from 'prop-types';
import PreviewEmail from './PreviewEmail';
import CreateEmail from './CreateEmail';
import { DragDropContext } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';
import 'bootstrap/dist/js/bootstrap.min';
import 'bootstrap/dist/css/bootstrap.min.css';
import Config from './Config';
import Guid from 'guid';
import _ from 'lodash';
import $ from 'jquery';
class App extends Component {
  state = {
    page: 'Dashboard',
    param_email_id: 0,
    emails: [],
    categories:[],
    types:[],
    totalEmails: 0,
    offset: 0,
    pageNo: 1,
    site: 'wp_2_',
    articles: [],
    otherArticles: [],
    ratedArticles: [],
    totalArticles: 0,
    totalOtherArticles: 0,
    totalRatedArticles: 0,
    selectedArticles: [],
    selectedEventArticles: [],
    selectedEditorArticles: [],
    selectedStoryArticles: [],
    selectedType: 1,
    selectedCategory: 0,
    isLoadingEmails: true,
    isLoadingCategories: false,
    isLoadingEmail: true,
    isLoadingSearch: false,
    isLoadingLatest: false,
    isLoadingMostRated: false,
    isLoadingStory: false,
    articlePage: 1,
    highlight: '',
    staticHighlight: '',
    hasTopLeaderboard: "0",
    hasFooterLeaderboard: "0",
    hasNewsletterSubscribe: "0",
    hasSponsoredContent: "0",
    topLeaderboard: '',
    footerLeaderboard: '',
    sponsoredContent: '',
    newsletterSubscribe: ''
  };

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
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/statictemplate?template='+ template +'&prefix='+ this.state.site +'&cache='+ Guid.raw(), {
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

  onStaticDragged = (props) => {
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

  onCancelStaticDrag = () => {
    this.setState(prevState => ({staticHighlight: ''}));
  }

  onCancelDrag = () => {
    this.setState(prevState => ({highlight: ''}));
  }

  onArticleDragged = (props) => {
    console.log(props);
    console.log(this.state.selectedCategory);
    if(parseInt(this.state.selectedCategory) === 35){
     this.setState(prevState => ({highlight: 'events'}));
    }
    else if(parseInt(this.state.selectedCategory) === 45){
     this.setState(prevState => ({highlight: 'editor'}));
    }
    else if(props.type !== undefined){
     this.setState(prevState => ({highlight: 'story'}));
    }
    else{
      this.setState(prevState => ({highlight: 'articles'}));
    }
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
    }, () => this.getPosts());
  }

  onChangeTemplate = () => {
    this.setState({
      selectedArticles: [],
      hasTopLeaderboard: "0",
      hasFooterLeaderboard: "0",
      hasNewsletterSubscribe: "0",
      hasSponsoredContent: "0"
    });
  }

  onRemoveEditor = (event) => {
    this.setState({selectedEditorArticles: this.state.selectedEditorArticles.filter((article) => {
          return parseInt(article.ID) !== parseInt(event.target.id)
      })});
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID) === parseInt(event.target.id)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  onRemoveEvent = (event) => {
    this.setState({selectedEventArticles: this.state.selectedEventArticles.filter((article) => {
          return parseInt(article.ID) !== parseInt(event.target.id)
      })});
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID) === parseInt(event.target.id)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
  }

  resetArticles = () => {
    this.setState(prevState => ({articles : [], totalArticles: 0}))
  }

  getMostRatedPosts = () => {
    this.setState(prevState => ({ratedArticles : [], totalRatedArticles: 0, isLoadingMostRated: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsmostrated?page='+ this.state.articleRatedPage + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
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
        console.log(val);
         this.setState({articles : val[0], totalArticles: val[1]})
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
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
        console.log(val);
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
         console.log(val);
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
         console.log(val);
         this.setState(prevState => ({otherArticles : val[0], totalOtherArticles: val[1]}))
       }).catch(err => {
        this.setState(prevState => ({isLoadingStory: false}))
       });
      });
  }
  onArticleDropped = (emailType, articleId, selectedTab, type) => {
    console.log(this.state.selectedCategory);
    this.setState(prevState => ({highlight: ''}));
    if(type === undefined){
      if(selectedTab === 'Latest' || selectedTab === 'Search'){
        if(parseInt(this.state.selectedCategory) === 35){
          _.each(this.state.articles, (article, index) => {
           if(parseInt(article.ID) === articleId){
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
             if(parseInt(article.ID) === articleId){
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
           if(parseInt(article.ID) === articleId){
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
      else if(selectedTab === 'MostRated'){
        _.each(this.state.ratedArticles, (article, index) => {
         if(parseInt(article.ID) === articleId){
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
    else{
      _.each(this.state.otherArticles, (article, index) => {
       if(parseInt(article.ID) === articleId){
         article.site = type;
         var result = _.filter(this.state.selectedStoryArticles, art => art.site === type);
         console.log(result);
         if(result.length === 0){
          this.setState(prevState => ({
            selectedStoryArticles: [...prevState.selectedStoryArticles, article]
          }));
         }
         else{
          this.setState(prevState => ({
            selectedStoryArticles: [..._.filter(prevState.selectedStoryArticles, art => art.site !== type), article]
          }));
         }
         this.setState({
           otherArticles: update(this.state.otherArticles, {[index]: {isDisabled: {$set: true}}})
         })
       }
      })
    }
  }

  onRemoveArticle = (event) => {
    console.log(event.target.id);
    this.setState({selectedArticles: this.state.selectedArticles.filter(function(article) {
          return parseInt(article.ID) !== parseInt(event.target.id)
      })});
      _.each(this.state.articles, (article, index) => {
       if(parseInt(article.ID) === parseInt(event.target.id)){
        this.setState({
          articles: update(this.state.articles, {[index]: {isDisabled: {$set: false}}})
        })
       }
      });
      _.each(this.state.ratedArticles, (article, index) => {
       if(parseInt(article.ID) === parseInt(event.target.id)){
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
      console.log(val);
       this.setState({emails : val[0], totalEmails: val[1], isLoadingEmails: false})
     }).catch(err => {
       this.setState(prevState => ({isLoadingEmails: false}));
     });
    });
  };

  onSetSite = (site) => {
    console.log(site);
    this.setState(prevState => ({ site: site,
                                  offset: 0,
                                  pageNo: 1,
                                  selectedArticles: [],
                                  selectedEventArticles: [],
                                  selectedEditorArticles: [],
                                  hasTopLeaderboard: '0',
                                  hasFooterLeaderboard: '0',
                                  hasNewsletterSubscribe: '0',
                                  hasSponsoredContent: '0',
                                  topLeaderboard: '',
                                  footerLeaderboard: '',
                                  newsletterSubscribe: '',
                                  sponsoredContent: ''}), () => {
     this.getEmails(this.state.offset);
     this.getCategories();
     this.getTypes();
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
        console.log(val);
         this.setState({articles : val[0], totalArticles: val[1]})
         // this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
       }
      this.setState({isLoadingLatest: false})
     }).catch(err => {
      this.setState({isLoadingLatest: false})
     });
    });
  }

  getMostRatedPosts = () => {
    this.setState(prevState => ({ratedArticles : [], totalRatedArticles: 0, isLoadingMostRated: true}))
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/postsmostrated?page='+ this.state.articleRatedPage + '&prefix='+ this.state.site + '&cache='+ Guid.raw(), {
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
      console.log(val);
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
      console.log(val);
       val.push({id: 1, name: 'All'});
       this.setState({types : val})
     });
    });
  }
  onNextPage = () => {
    this.setState(prevState => ({
      pageNo: prevState.pageNo + 1,
      offset: prevState.offset + 5
    }), () => this.getEmails(this.state.offset));
  }

  onPreviousPage = () => {
    this.setState(prevState => ({
      pageNo: prevState.pageNo - 1,
      offset: prevState.offset - 5
    }), () => this.getEmails(this.state.offset));
  }

  editEmail = (event) => {
   event.preventDefault();
   this.onChangePage('CreateEmail', event.target.id);
  }


  livePreview = (event) => {
   event.preventDefault();
   window.open('https://pa.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id);
  }
  onChangePage = (page, param) => {
    console.log(page);
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
      return "Are you sure you want to leave?";
    }
    this.setState(prevState => ({
      site: 'wp_2_',
    }));
    this.getEmails(this.state.offset);
  }

  onLoadingEmail = (value) => {
    this.setState(prevState => ({isLoadingEmail: false}))
  }

  render() {
    return (
      <div className="container">
         <Header onChangePage={this.onChangePage} currentPage={this.state.page} onSetSite={this.onSetSite} site={this.state.site}/>
         { this.state.page === 'Dashboard' ? 
          <div className="container">
             <div className="row">
               <div className="col-xs-12">
                 <h1>Newsletters</h1>
               </div>
             </div>
               <div className="row">
                 <div className="col-xs-12">
                { this.state.isLoadingEmails === true ? <div className="tab-pane fade active in" style={{textAlign: 'center'}}><img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif"/></div> : 
                   <table className="table">
                     <thead>
                       <tr>
                         <th>Email Name</th>
                         <th>Status</th>
                         <th>Edit</th>
                       </tr>
                     </thead>
                     <tbody>
                     {this.state.emails.map((email, key) => {
                       return <tr key={key}>
                         <td>{email.EmailName}</td>
                         <td>{email.SendToAdestraOn}</td>
                         <td><button type="button" disabled={email.SendToAdestraOn !== null}  id={email.EmailId} onClick={this.editEmail} className="btn btn-primary">Edit</button></td>
                         <td><button type="button" disabled={email.SendToAdestraOn !== null}  id={email.EmailId} onClick={this.livePreview} className="btn btn-primary">Live Preview</button></td>
                       </tr>
                       })}
                     </tbody>
                   </table>}
                 </div>
               </div>
             <div className="row">
               <div className="col-xs-12">
                 <ul className="pager">
                   <li className="previous dis">{this.state.pageNo > 1 ? <a href="#" onClick={this.onPreviousPage}>Previous</a> : ''}</li>
                   <li className="next">{this.state.pageNo < Math.ceil(this.state.totalEmails / 5) ? <a href="#" onClick={this.onNextPage}>Next</a> : ''}</li>
                 </ul>
               </div>
             </div>
           </div>
           : ''}
         { this.state.page === 'CreateEmail' ?  <CreateEmail
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
                                                   getPostsByType={this.getPostsByType}
                                                   getPostsBySite={this.getPostsBySite}
                                                   resetArticles={this.resetArticles}
                                                   getPosts={this.getPosts}
                                                   getMostRatedPosts={this.getMostRatedPosts}
                                                   onChangeTemplate={this.onChangeTemplate}
                                                   onRemoveEvent={this.onRemoveEvent}
                                                   onRemoveEditor={this.onRemoveEditor}
                                                   articles={this.state.articles}
                                                   otherArticles={this.state.otherArticles}
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
                                                   footerLeaderboard={this.state.footerLeaderboard}
                                                   sponsoredContent={this.state.sponsoredContent}
                                                   newsletterSubscribe={this.state.newsletterSubscribe}
                                                   highlight={this.state.highlight}
                                                   staticHighlight={this.state.staticHighlight}
                                                   hasTopLeaderboard={this.state.hasTopLeaderboard}
                                                   hasFooterLeaderboard={this.state.hasFooterLeaderboard}
                                                   hasNewsletterSubscribe={this.state.hasNewsletterSubscribe}
                                                   hasSponsoredContent={this.state.hasSponsoredContent}
                                                   /> : ''}
         { this.state.page === 'PreviewEmail' ? <PreviewEmail onChangePage={this.onChangePage} emailId={this.state.param_email_id} site={this.state.site}/>  : ''}
      </div>
    );
  }
}

export default App;
