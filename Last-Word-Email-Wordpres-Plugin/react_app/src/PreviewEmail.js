import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import update from 'react-addons-update';
import VideoNewsLetter from './VideoNewsLetter';
import InsightsNewsLetter from './InsightsNewsLetter';
import DigitalMagazineNewsLetter from './DigitalMagazineNewsLetter';
import BreakingNewsNewsLetter from './BreakingNewsNewsLetter';
import PortfolioAdviserNewsLetter from './PortfolioAdviserNewsLetter';
import Article from './Article';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';

class PreviewEmail extends Component {
  state = { 
    content: ''
  };

 constructor(props) {
    super(props);
    this.timeout =  0;
    this.props.emailId > 0 ? this.getEmail(this.props.emailId) : '';
  }


  getEmail = () => {
    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/email?emailId='+ this.props.emailId + '&cache='+ Guid.raw(), {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
     result.json().then(val => {
       this.setState(prevState => ({
         content: val.Content}))
     });
    });
  }

  render() {
    return (
   <div className="container">
      <div className="row">
        <div className="col-xs-8" id="emailContent" ref="emailContent" dangerouslySetInnerHTML={{__html:this.state.content}}></div>
      </div>
    </div>
    );
  }
}

export default PreviewEmail;
