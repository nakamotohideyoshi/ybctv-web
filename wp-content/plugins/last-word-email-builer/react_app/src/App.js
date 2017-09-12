import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import Header from './Header';
import PropTypes from 'prop-types';
import Dashboard from './Dashboard';
import PreviewEmail from './PreviewEmail';
import CreateEmail from './CreateEmail';
import { DragDropContextProvider } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';
import 'bootstrap/dist/js/bootstrap.min';
import 'bootstrap/dist/css/bootstrap.min.css';
import Config from './Config';
import Guid from 'guid';
import $ from 'jquery';
class App extends Component {
  state = {
    page: 'Dashboard',
    param_email_id: 0,
    emails: [],
    totalEmails: 0,
    cache: '',
    offset: 0,
    pageNo: 1,
  };

  getEmails = (offset) => {
    this.setState(prevState => ({ cache: Guid.raw()}), () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/emails?offset='+ offset +'&cache='+ this.state.cache, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
      console.log(val);
       this.setState(prevState => ({emails : val[0], totalEmails: val[1]}))
     });
    });
  })};

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
    this.getEmails(this.state.offset);
  }

  render() {
    return (
      <div className="container">
         <Header onChangePage={this.onChangePage} currentPage={this.state.page}/>
         { this.state.page === 'Dashboard' ? 
          <div className="container">
             <div className="row">
               <div className="col-xs-12">
                 <h1>Newsletters</h1>
               </div>
             </div>
               <div className="row">
                 <div className="col-xs-12">
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
                   </table>
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
         { this.state.page === 'CreateEmail' ?   <DragDropContextProvider backend={HTML5Backend}><CreateEmail onChangePage={this.onChangePage} emailId={this.state.param_email_id} /></DragDropContextProvider> : ''}
         { this.state.page === 'PreviewEmail' ? <PreviewEmail onChangePage={this.onChangePage} emailId={this.state.param_email_id}/>  : ''}
      </div>
    );
  }
}

export default App;
