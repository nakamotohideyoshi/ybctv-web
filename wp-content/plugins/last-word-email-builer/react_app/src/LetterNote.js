import React, { Component } from 'react';

class LetterNote extends Component {
  render() {
	let people = ['', 'A', 'B', 'C', 'D', 'E', 'F'];

    return (
 	  	<address style={{ 'margin': 0 }}>
 	  		<div style={{ 'position': 'relative' }}>
	 	  		<div style={{ 'position': 'absolute', 'right': 10, 'bottom': 10, 'fontSize': '12px', 'color': '#fff', 'background': '#000', 'fontWeight': 'bold', 'padding': '5px' }}>
	     	  		{people[this.props.letter]}
	     		</div>
     		</div>
  		</address>
    );
  }
}

export default LetterNote;
