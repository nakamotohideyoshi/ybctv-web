import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DragSource } from 'react-dnd';
// import { getEmptyImage } from 'react-dnd-html5-backend';
import ItemTypes from './ItemTypes';

const style = {
};

const boxSource = {
  beginDrag(props) {
    console.log('*** DRAG STARTED ****');
    props.onStaticDragged(props);
    return {
      name: props.name,
      text: props.text
    };
  },

  endDrag(props, monitor) {
    console.log('*** DRAG ENDED ****');
    // const item = monitor.getItem();
    const dropResult = monitor.getDropResult();

    if (dropResult) {
      console.log(dropResult);
      console.dir(props);
      props.onStaticDropped(props.name);
      props.onCancelStaticDrag();
    }
    else{
     props.onCancelStaticDrag();
    }
  },
};

 class DragStatic extends Component {
  static propTypes = {
    connectDragSource: PropTypes.func.isRequired,
    isDragging: PropTypes.bool.isRequired,
    name: PropTypes.string.isRequired
  };

  onShowPreviewBox = () => {
    this.props.onShowPreviewBox( this.props.name );
  }

  render() {
    const { onClick, isDragging, connectDragSource } = this.props;
    const { name, text, id } = this.props;
    const opacity = isDragging ? 0.4 : 1;
    return connectDragSource(
      <div className="col-md-4" style={{ 'padding': '0 5px' }}>
        <div style={{ ...style, opacity }}>
          <button style={{ 'white-space': 'normal', 'line-height': '14px' }} onMouseEnter={this.onShowPreviewBox} onMouseLeave={this.props.onHidePreviewBox} onClick={onClick} id={id} className="btn btn-primary btn-block btn-sm" type="button" aria-expanded="false" aria-controls="collapseExample" disabled={!this.props.isDisabled}>
            {text}
          </button>
        </div>
      </div>
    );
  }
}

export default DragSource(ItemTypes.BOX, boxSource, (connect, monitor) => ({
  connectDragSource: connect.dragSource(),
  isDragging: monitor.isDragging(),
})
)(DragStatic);
