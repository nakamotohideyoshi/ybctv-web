import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';


const style = {
  background: '#E6E6E6',
};

const boxTarget = {
  drop(props, monitor, component) {
    const item = monitor.getItem();
    console.log(monitor.getItemType());
    console.log(component);
    props.onArticleDropped(item.id,'Most_Viewed');
    return { name: props.email };
  },
};

class MostViewedComponent extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   selectedMostViewedArticles: PropTypes.any.isRequired,
   color: PropTypes.any.isRequired
 };
render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;
  let color = this.props.color;

      return connectDropTarget(
  <table data-width="100%" style={this.props.highlight === 'rated' ? {animation : 'blink .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
                  <tbody><tr>
                          <td style={this.props.isAllBlocks !== undefined ? {fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'} : {color,fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'}}> 
                                  <font style={{fontFamily:'Georgia'}}>
                                          Most viewed in the past week
                                  </font> 
                          </td>
                  </tr>
                    {this.props.selectedMostViewedArticles.map((article, index) => {
  return <tr key={article.ID}>
  <td>
  <table style={{width: '100%'}} data-border="0" data-width="100%">
          <tbody>
                          <tr>
                                  <td data-width="10%" style={{color: '#d50032',padding: '10px 0px 0px', fontFamily: 'Arial, Helvetica, sans-serif', fontWeight: 'bold', verticalAlign: 'top', fontSize: '14px', width: '10%'}}>{index + 1}.</td>
                                  <td data-width="90%" style={{padding: '8px 8px 0px', width: '90%', textAlign:'left', position: 'relative'}}>
                                          <a href={article.guid} style={{color,fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none'}}><font>{article.post_title}</font></a>
                                          <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveArticle}/>
                                  </td>
                          </tr>
          </tbody>
  </table>
  </td>
  </tr>})}</tbody></table>
    );
  }
}

export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
  connectDropTarget: connect.dropTarget(),
  isOver: monitor.isOver(),
  canDrop: monitor.canDrop(),
})
)(MostViewedComponent);
