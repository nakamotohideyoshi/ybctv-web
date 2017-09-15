import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DragSource } from 'react-dnd';
// import { getEmptyImage } from 'react-dnd-html5-backend';
import ItemTypes from './ItemTypes';

const style = {
};

const boxSource = {
  beginDrag(props) {
    props.onStaticDragged(props);
    return {
      name: props.name,
      text: props.text
    };
  },

  endDrag(props, monitor) {
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
  render() {
    const { onClick, isDragging, connectDragSource } = this.props;
    const { name, text, id } = this.props;
    const opacity = isDragging ? 0.4 : 1;
    return connectDragSource(
      <div style={{ ...style, opacity }}>
      <button onClick={onClick} id={id} className="btn btn-primary btn-block" type="button" aria-expanded="false" aria-controls="collapseExample">
      {text}
      </button>
      </div>
    );
  }
}

export default DragSource(ItemTypes.BOX, boxSource, (connect, monitor) => ({
  connectDragSource: connect.dragSource(),
  isDragging: monitor.isDragging(),
})
)(DragStatic);
