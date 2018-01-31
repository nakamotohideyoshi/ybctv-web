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
    props.onArticleDropped(item.id,'Events');
    return { name: props.email };
  },
};

class EventsComponent extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   selectedEventArticles: PropTypes.any.isRequired,
   color: PropTypes.any.isRequired
 };
render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;
  let color = this.props.color;

      return connectDropTarget(
  <table data-width="100%" style={this.props.highlight === 'event' ? {animation : 'twinkle .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
                  <tbody><tr>
                          <td style={this.props.isAllBlocks !== undefined ? {fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'} : {color,fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'}}> 
                                  <font style={{fontFamily:'Georgia'}}>
                                          Events
                                  </font> 
                          </td>
                  </tr>
                    {this.props.selectedEventArticles.map((article, key) => {
                      var formatDate = function(date) {
                        var datePieces = date.split(' ');
                        date = datePieces[2] + ' ' + datePieces[1] + ' ' + datePieces[3];
                        
                        return date;
                      };
  return <tr key={key}>
  <td>
  <table style={{width: '100%'}}>
          <tbody>
                          <tr>
                                  <td style={{padding:'7px 0px 7px', position: 'relative'}}>
                                          <a href={article.link} style={{color,fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none'}}><font>{article.post_title}</font></a>
                                          <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveEvent}/>
                                  </td>
                          </tr>
            <tr>
               <td style={{fontFamily:'Arial, Helvetica, sans-serif',fontSize: '14px',padding:'0px 0px 2px 0px',color: '#2c2c2c'}}>
                  <font>
                  {formatDate((new Date(article.startdate.replace(/(\d{4})(\d{2})(\d{2})/,'$1-$2-$3'))).toDateString())}
                  </font>
               </td>
            </tr>
          </tbody>
  </table>
  </td>
  </tr>
                  })}
  </tbody></table>
    );
  }
}

export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
  connectDropTarget: connect.dropTarget(),
  isOver: monitor.isOver(),
  canDrop: monitor.canDrop(),
})
)(EventsComponent);
