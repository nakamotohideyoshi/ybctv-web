import React, { Component } from 'react';

class PreviewBox extends Component {
  closePreview = () => {
    this.props.closePreviewBox();
  }

  render() {
    return (
     	  <div style={{ 'display': this.props.show ? 'block' : 'none', 'position': 'fixed', 'left': 200, 'top': 50, 'border': '1px solid #000', 'background': '#fff', 'zIndex': 20, 'minWidth': 400, 'maxWidth': 800, 'minHeight': 100 }}>
			     <div onClick={ this.closePreview }  style={{ 'position': 'absolute', 'right': 0, 'top': 0, 'background': '#000', 'padding': '5px', 'cursor': 'pointer', 'color': '#fff' }}>Close</div>
           <div dangerouslySetInnerHTML={{__html: this.props.content }}></div>
	 	    </div>
    );
  }
}

export default PreviewBox;
