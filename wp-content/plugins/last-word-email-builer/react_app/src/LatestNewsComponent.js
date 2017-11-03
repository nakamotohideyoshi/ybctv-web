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
    props.onArticleDropped(item.id,'Latest_News');
    return { name: props.email };
  },
};

class LatestNewsComponent extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   articles: PropTypes.any.isRequired,
   color: PropTypes.any.isRequired
 };
render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;
  let color = this.props.color;

      return connectDropTarget(
  <table data-width="100%" style={this.props.highlight === 'article' ? { animation : 'blink .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
          <tbody><tr>
                  <td style={this.props.isAllBlocks !== undefined ? {fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'} : {fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia', color}}>
                  {this.props.isBreakingNews !== undefined ? <font style={{fontFamily:'Georgia'}}> Breaking news </font> : ''}
                  {this.props.isLatestNews !== undefined ? <font style={{fontFamily:'Georgia'}}> Latest news </font> : ''}
                  {this.props.isChinaNews !== undefined ? <font style={{fontFamily:'Georgia'}}> Latest China news </font> : ''}
                  {this.props.isAllBlocksNews !== undefined ? <font style={{fontFamily:'Georgia'}}> Latest news </font> : ''}
                  {this.props.isVideoNews !== undefined ? <font style={{fontFamily:'Georgia'}}> Video </font> : ''}
                  {this.props.isInsights !== undefined ? <font style={{fontFamily:'Georgia'}}> Insights </font> : ''}
                  </td>
          </tr>

          {this.props.articles.map((article,key) => {
                          return article !== null ?  <tr key={key}>
                          {this.props.isInsights === undefined ? <td>
                  <table style={{borderBottom: '1px solid #e5eaee', width: '100%', position: 'relative'}} data-width="100%">
                          <tbody><tr>
                                                                  <td className="container_sub" style={this.props.isAllBlocksNews !== undefined ? {padding:'20px 10px 14px 0px',verticalAlign: 'top', width: '180px'} : {padding:'20px 10px 14px 0px',verticalAlign: 'top', width: '230px'}}> 
                                                                          <a href={article.guid}>
                                                                           <img data-width="219" src={ article.featured_image !== null && typeof article.featured_image != 'undefined' ? article.featured_image : "http://www.expertinvestoreurope.com/w-images/2dd14d1d-57c2-4dfb-b6c9-ed1644ebb96d/2/cliffdownmoneydanger-219x122.jpg"} style={ this.props.isAllBlocksNews !== undefined ? {width: '180px'} : {maxWidth:'219px',height:'122px',width:'219px'}} title={article.post_title}/>
                                                                           </a>
                                                                  </td>
                                                                  <td className="container_sub" style={{verticalAlign: 'top',padding:'13px 0px 14px'}}>						
                                                                          <table data-width="100%">
                                                                                          <tbody><tr>
                                                                                                  <td style={{padding: '0px 0px 7px'}}>
                                                                                                   <a href={article.guid} style={{fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none', color}} title={article.post_title}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{article.post_title}</font></a> </td>
                                                                                          </tr>
                                                                                          <tr>
                                                                                                  <td style={{color: '#2c2c2c',fontSize: '14px',fontFamily: 'Arial, Helvetica, sans-serif',lineHeight: '20px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}} dangerouslySetInnerHTML={{__html:article.post_excerpt.replace(/^(.{110}[^\s]*).*/, "$1...")}}></font></td>
                                                                                          </tr>
                                                                          </tbody></table>
                                                                          <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width: '10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveArticle}/>
                                                                  </td>
                          </tr>
                  </tbody></table>
                  </td> : 
                    <td>
                  <table style={{borderBottom: '1px solid #e5eaee', width: '100%', position: 'relative'}} data-width="100%">
                          <tbody><tr>
                                                                  <td className="container_sub" data-width="718" style={this.props.isAllBlocksNews !== undefined ? {padding:'20px 10px 14px 0px',verticalAlign: 'top'} : {padding:'20px 10px 14px 0px',verticalAlign: 'top'}}> 
                                                                          <a href={article.guid}>
                                                                           <img src={ article.featured_image !== null ? article.featured_image : "http://www.expertinvestoreurope.com/w-images/2dd14d1d-57c2-4dfb-b6c9-ed1644ebb96d/2/cliffdownmoneydanger-219x122.jpg"}  title={article.post_title}/>
                                                                           </a>
                                                                  </td>
                          </tr>
                          <tr>
                          <td className="container_sub" style={{verticalAlign: 'top',padding:'13px 0px 14px'}}>						
                                  <table data-width="100%">
                                                  <tbody><tr>
                                                          <td style={{padding: '0px 0px 7px'}}>
                                                           <a href={article.guid} style={{fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none', color}} title={article.post_title}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}}>{article.post_title}</font></a> </td>
                                                  </tr>
                                                  <tr>
                                                          <td style={{color: '#2c2c2c',fontSize: '14px',fontFamily: 'Arial, Helvetica, sans-serif',lineHeight: '20px'}}><font style={{fontFamily:'Arial, Helvetica, sans-serif'}} dangerouslySetInnerHTML={{__html:article.post_excerpt.replace(/^(.{110}[^\s]*).*/, "$1...")}}></font></td>
                                                  </tr>
                                  </tbody></table>
                                  <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width: '10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={this.props.onRemoveArticle}/>
                          </td>
                          </tr>
                  </tbody></table>
                  </td>}
          </tr> : ''
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
)(LatestNewsComponent);
