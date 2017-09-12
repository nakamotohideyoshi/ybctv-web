// import React, { Component } from 'react';
// import PropTypes from 'prop-types';
// import VideoNewsLetter from './VideoNewsLetter';
// import InsightsNewsLetter from './InsightsNewsLetter';
// import DigitalMagazineNewsLetter from './DigitalMagazineNewsLetter';
// import BreakingNewsNewsLetter from './BreakingNewsNewsLetter';
// import PortfolioAdviserNewsLetter from './PortfolioAdviserNewsLetter';
// import { DropTarget } from 'react-dnd';
// import ItemTypes from './ItemTypes';
//
// const style = {
//   background: '#E6E6E6',
// };
//
// const boxTarget = {
//   drop(props) {
//     return { name: props.email };
//   },
// };
// class TemplateWrapper extends Component {
//   state = { };
//
//   static propTypes = {
//     connectDropTarget: PropTypes.func.isRequired,
//     isOver: PropTypes.bool.isRequired,
//     canDrop: PropTypes.bool.isRequired,
//   }
//
//   onStaticDropped = (name) => {
//   console.log(name);
//   
//   }
//   render() {
//     const { canDrop, isOver, connectDropTarget } = this.props;
//     const isActive = canDrop && isOver;
//
//     let border = 'none';
//     let borderStyle = 'none';
//     let overflow = 'visible';
//     if (isActive) {
//       border = '1px solid #000';
//       borderStyle = 'dashed';
//       overflow = 'hidden';
//     } else if (canDrop) {
//       border = '1px solid #000';
//       borderStyle = 'dashed';
//       overflow = 'hidden';
//     }
//       return connectDropTarget(
//       <div style={{ ...style, border, borderStyle, overflow }}>
//       { this.props.template === 'Video_Newsletter' ? <VideoNewsLetter articles={this.props.articles} onRemoveArticle={this.props.onRemoveArticle} onStaticDropped={drop => (this.onStaticDropped = drop)} />  : ''}
//       { this.props.template === 'Insights_Newsletter' ? <InsightsNewsLetter articles={this.props.articles} onRemoveArticle={this.props.onRemoveArticle} onStaticDropped={drop => (this.onStaticDropped = drop)} />  : ''}
//       { this.props.template === 'Digital_Magazine_Newsletter' ? <DigitalMagazineNewsLetter articles={this.props.articles} onRemoveArticle={this.props.onRemoveArticle} onStaticDropped={drop => (this.onStaticDropped = drop)}/>  : ''}
//       { this.props.template === 'Breaking_News_Newsletter' ? <BreakingNewsNewsLetter articles={this.props.articles} onRemoveArticle={this.props.onRemoveArticle} onStaticDropped={drop => (this.onStaticDropped = drop)}/>  : ''}
//       { this.props.template === 'Portfolio_Adviser_Newsletter' ? <PortfolioAdviserNewsLetter articles={this.props.articles} onRemoveArticle={this.props.onRemoveArticle} onStaticDropped={drop => (this.onStaticDropped = drop)}/>  : ''}
//       </div>
//     );
//   }
// }
//
// export default DropTarget(ItemTypes.BOX, boxTarget, (connect, monitor) => ({
//   connectDropTarget: connect.dropTarget(),
//   isOver: monitor.isOver(),
//   canDrop: monitor.canDrop(),
// })
// )(TemplateWrapper);
