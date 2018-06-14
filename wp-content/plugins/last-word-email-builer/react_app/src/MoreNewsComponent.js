import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';
import _ from 'lodash';
import $ from 'jquery';
import Config from './Config';
import Guid from 'guid';

// Using an ES6 transpiler like Babel
import {
	SortableContainer,
	SortableElement,
	arrayMove,
} from 'react-sortable-hoc';

const SortableItem = SortableElement(({value, onRemoveArticle}) => {
	let article = value;
	let color = '';
	let cThis = this;

	return <tr>
    <td>
      <table style={{width: '100%'}}>
        <tbody>
        <tr>
          <td style={{padding:'7px 0px 7px', position: 'relative'}}>
            <a href={article.guid} style={{color,fontSize: '14px',fontFamily:'Arial, Helvetica, sans-serif',textDecoration: 'none'}}><font>{article.post_title}</font></a>
            <img src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/cross.png" className="cross-img" style={{width:'10px',cursor:'pointer',position: 'absolute',right:'10px',top:'10px'}} id={article.ID} onClick={onRemoveArticle}/>
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>;

});


const SortableList = SortableContainer(({items, onRemoveArticle}) => {
	let cThis = this;
	return (
		<tr>
			<td>
				<table className="test-sortable">
					{items.map((value, index) => (
						<SortableItem key={`item-${index}`} index={index} value={value} onRemoveArticle={onRemoveArticle} />
					))}
				</table>
			</td>
		</tr>
	);
});


const style = {
  background: '#E6E6E6',
};

const boxTarget = {
  drop(props, monitor, component) {
    const item = monitor.getItem();
    console.log(monitor.getItemType());
    console.log(component);
    props.onArticleDropped(item.id,'More_News');
    return { name: props.email };
  },
};

class MoreNewsComponent extends Component {
static propTypes = {
   connectDropTarget: PropTypes.func.isRequired,
   isOver: PropTypes.bool.isRequired,
   canDrop: PropTypes.bool.isRequired,
   selectedMoreNewsArticles: PropTypes.any.isRequired,
 };



// consider everyone here...
onSortEnd = ({oldIndex, newIndex}) => {
	let newArticles = arrayMove(this.props.selectedMoreNewsArticles, oldIndex, newIndex);

	console.log('new articles:');
	console.log(newArticles);

	this.props.onArticleSortUpdated(newArticles, 'More_News');
};

render() {
  const { canDrop, isOver, connectDropTarget } = this.props;
  const isActive = canDrop && isOver;
  let color = this.props.color;
  let cThis = this;

      return connectDropTarget(
  <div class="test1">
  <table style={this.props.highlight === 'article' ? {animation : 'twinkle .5s step-end infinite alternate', border: '2px solid', width: '100%'} : {width: '100%'}}>
  <tbody><tr>
  <td style={this.props.isAllBlocks !== undefined ? {fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'} : {color,fontSize: '22px',fontWeight: 'normal',borderBottom: '1px solid #e5eaee',padding: '10px 0px 3px 0px',fontFamily:'Georgia'}}> 
          <font style={{fontFamily:'Georgia'}}>
                  More news
          </font> 
  </td>
  </tr>

  <SortableList pressDelay="200" items={this.props.selectedMoreNewsArticles} onSortEnd={cThis.onSortEnd} onRemoveArticle={cThis.props.onRemoveArticle.bind(cThis)} />

  </tbody></table>
        </div>
    );
  }
}

export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
  connectDropTarget: connect.dropTarget(),
  isOver: monitor.isOver(),
  canDrop: monitor.canDrop(),
})
)(MoreNewsComponent);
