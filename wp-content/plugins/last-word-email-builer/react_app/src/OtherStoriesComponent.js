import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import OtherStoryFundSelectorAsiaComponent from './OtherStoryFundSelectorAsiaComponent';
import OtherStoryInternationalAdviserComponent from './OtherStoryInternationalAdviserComponent';
import OtherStoryPortfolioAdviserComponent from './OtherStoryPortfolioAdviserComponent';
import OtherStoryExpertInvestorComponent from './OtherStoryExpertInvestorComponent';
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
    props.onArticleDropped(item.id,'Story', item.site);
    return { name: props.email };
  },
};

class OtherStoriesComponent extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   selectedStoryArticles: PropTypes.any.isRequired,
   color: PropTypes.any.isRequired
 };
render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;
  let color = this.props.color;

      return connectDropTarget(
  <div>
  <table  data-width="728" data-align="center" className="device_innerblock" style={this.props.highlight === 'story' ? { animation : 'twinkle .5s step-end infinite alternate', border: '2px solid', width: '728px',textAlign: 'center'} : {width: '728px',textAlign: 'center'}}>
          <tr>
                  <td>
                  {this.props.site === 'wp_5_'  ?
                    <div>
                      <OtherStoryPortfolioAdviserComponent float="left"  selectedStoryArticles={this.props.selectedStoryArticles}/>
                      <OtherStoryFundSelectorAsiaComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                      <OtherStoryInternationalAdviserComponent selectedStoryArticles={this.props.selectedStoryArticles} float="right"/>
                   </div>
    : ''}
                                           {this.props.site === 'wp_4_' ?
                   <div>
                     <OtherStoryPortfolioAdviserComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                     <OtherStoryExpertInvestorComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                     <OtherStoryInternationalAdviserComponent selectedStoryArticles={this.props.selectedStoryArticles} float="right"/>
                  </div>
    : ''}
                                           {this.props.site === 'wp_3_'  ? 
                  <div>
                    <OtherStoryExpertInvestorComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                    <OtherStoryFundSelectorAsiaComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                    <OtherStoryPortfolioAdviserComponent selectedStoryArticles={this.props.selectedStoryArticles} float="right"/>
                 </div>
    : ''}
                                           {this.props.site === 'wp_2_' ?
                 <div>
                   <OtherStoryFundSelectorAsiaComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                   <OtherStoryExpertInvestorComponent selectedStoryArticles={this.props.selectedStoryArticles} float="left"/>
                   <OtherStoryInternationalAdviserComponent selectedStoryArticles={this.props.selectedStoryArticles} float="right"/>
                </div>
    : ''}
                  </td>
          </tr>
          </table>
        </div>
    );
  }
}

export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
  connectDropTarget: connect.dropTarget(),
  isOver: monitor.isOver(),
  canDrop: monitor.canDrop(),
})
)(OtherStoriesComponent);
