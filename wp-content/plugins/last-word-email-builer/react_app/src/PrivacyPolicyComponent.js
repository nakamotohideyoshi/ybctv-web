import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';


class PrivacyPolicyComponent extends Component {
static propTypes = {
   site: PropTypes.any.isRequired
 };
render() {
      return (
          <span>
            {this.props.site === 'wp_2_' ? <font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>
            <a href="https://www.portfolio-adviser.com/privacy-policy/" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>Privacy policy </a> 
            | <a href="https://www.portfolio-adviser.com/terms-and-conditions/" target="_blank" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}> Terms &#38; conditions.</a></font>: ''}
            {this.props.site === 'wp_3_' ? <font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>
            <a href="https://www.international-adviser.com/privacy-policy/" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>Privacy policy </a> 
            | <a href="https://www.international-adviser.com/terms-and-conditions/" target="_blank" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}> Terms &#38; conditions.</a></font> : ''}
            {this.props.site === 'wp_4_' ? <font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>
            <a href="https://www.fundselectorasia.com/privacy-policy/" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>Privacy policy </a> 
            | <a href="https://www.fundselectorasia.com/terms-and-conditions/" target="_blank" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}> Terms &#38; conditions.</a></font> : ''}
            {this.props.site === 'wp_5_' ? <font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>
            <a href="https://www.expertinvestoreurope.com/privacy-policy/" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}>Privacy policy </a> 
            | <a href="https://www.expertinvestoreurope.com/terms-and-conditions/" target="_blank" style={{color:'#FFFFFF',textDecoration: 'none',fontFamily: 'Arial, Helvetica, sans-serif'}}> Terms &#38; conditions.</a></font> : ''}
          </span>
    );
  }
}

export default PrivacyPolicyComponent;
