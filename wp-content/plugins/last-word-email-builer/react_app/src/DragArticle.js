/*

This class generates the articles and events buttons which can be dragged inside the templates 
from the right sidebar in the create email screen.

*/

import React, { Component } from 'react';
import { findDOMNode } from 'react-dom';
import PropTypes from 'prop-types';
import { DragSource } from 'react-dnd';
// import { getEmptyImage } from 'react-dnd-html5-backend';
import ItemTypes from './ItemTypes';

const style = {
};

const boxSource = {
  beginDrag(props) {
    console.log('*** DRAG STARTED ****');
    props.onArticleDragged(props);
    return {
      desc: props.desc,
      id: props.id,
      isDisabled: props.isDisabled,
      name: props.name,
      category: props.category,
      type: props.type,
      site: props.site
      // color: props.color
    };
  },


  endDrag(props, monitor) {
    console.log('*** DRAG ENDED ****');
    const item = monitor.getItem();
    const dropResult = monitor.getDropResult();

    // console.dir(item);
    // console.dir(dropResult);
    // if (dropResult) {
    //   // window.alert( // eslint-disable-line no-alert
    //   //   `You dropped ${item.name} into ${dropResult.name}!`,
    //   // );
    //   // props.onArticleDropped(dropResult.name, item.id,item.type);
    // }
    // else{
     props.onCancelDrag();
    // }
  },
};

 class DragArticle extends Component {
  static propTypes = {
    connectDragSource: PropTypes.func.isRequired,
    isDragging: PropTypes.bool.isRequired,
    name: PropTypes.string.isRequired,
    desc: PropTypes.string.isRequired,
    image: PropTypes.string,
    id: PropTypes.number.isRequired,
    isDisabled: PropTypes.bool,
    // color: PropTypes.string
  };
  render() {
    const { isDragging, connectDragSource } = this.props;
    const { name, desc, image, id, isDisabled} = this.props;
    const opacity = isDragging ? 0.4 : 1;

    let isBadImage = false;
    if (  typeof this.props.article.post_type !== 'undefined' &&
          typeof this.props.article.featured_image !== 'undefined'  &&
          this.props.article.post_type === 'post'
    ) {
      isBadImage = this.props.article.featured_image === null || this.props.article.featured_image.indexOf('-219x122') === -1;
    }

    return connectDragSource(
      <div style={{ ...style, opacity }}>
      <button className="btn btn-primary btn-block collapsed" disabled={isDisabled || isBadImage} type="button" data-toggle="collapse" data-target={"#collapsearticle"+ id} aria-expanded="false" aria-controls="collapseExample">
        {name.substring(0,50)}
      </button>
      <div style={{ 'display': isBadImage ? 'block' : 'none', 'fontSize': '12px', 'margin': '-5px 0 10px' }}>
        <a href={ '/wp-admin/post.php?post=' + this.props.article.ID + '&action=edit' } target="_blank">This article uses a Kreatio legacy featured image not supported in this version of mailbuilder. Please edit the article to set a new featured image via Wordpress as you usually do, and then save your update. The article can then be used.</a>
      </div>
      <div className="collapse" id={"collapsearticle"+ id} aria-expanded="false" >
        <div className="well">
          <img src={image} className="img-responsive"/>
          <p dangerouslySetInnerHTML={{__html:desc.substring(0,500)}}></p>
        </div>
      </div>
      </div>
    );
  }
}

export default DragSource(ItemTypes.BOX, boxSource, (connect, monitor) => ({
  connectDragSource: connect.dragSource(),
  isDragging: monitor.isDragging(),
})
)(DragArticle);
