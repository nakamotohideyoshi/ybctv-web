import React, { Component } from 'react';

class PreviewBox extends Component {
  onChangePage = (event) => {
    event.preventDefault();
    this.props.onChangePage(event.target.name);
  }

  render() {
    return (
     	<div style={{ 'display': this.props.show ? 'block' : 'none', 'position': 'fixed', 'left': 20, 'top': 20, 'border': '1px solid #000', 'background': '#fff', 'zIndex': 10, 'minWidth': 400, 'maxWidth': 800, 'minHeight': 100 }}>
			<div dangerouslySetInnerHTML={{__html: this.props.content }}></div>
	 	</div>
    );
  }
}

export default PreviewBox;
