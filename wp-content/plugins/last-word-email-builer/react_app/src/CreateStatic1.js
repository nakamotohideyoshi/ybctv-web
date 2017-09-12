// import React, { Component } from 'react';
// import ReactDOM from 'react-dom';
// import { Editor } from 'react-draft-wysiwyg';
// import { EditorState, convertToRaw, ContentState, Modifier, convertFromRaw, AtomicBlockUtils, RichUtils, Entity } from 'draft-js';
// import { convertToHTML } from 'draft-convert';
// import PropTypes from 'prop-types';
// import draftToHtml from 'draftjs-to-html';
// import {stateToHTML} from 'draft-js-export-html';
// import '../node_modules/react-draft-wysiwyg/dist/react-draft-wysiwyg.css';
// import $ from 'jquery';
// import _ from 'lodash';
// import Gallery from 'react-grid-gallery';
//
// class ImageImportOption extends Component {
//   static propTypes = {
//     onChange: PropTypes.func,
//     editorState: PropTypes.object,
//   };
//
//   state = {
//    images: [],
//    selectedImages: []
//   }
//
//   addImage: Function = (): void => {
//     fetch('http://local.inkskill.com/wordpress/wp-json/email-builder/v1/images', {
//       method: 'GET',
//       headers: {
//         'Accept': 'application/json',
//         'Content-Type': 'application/json',
//       }
//     }).then(result => {
//       result.json().then(val => {
//         this.setState(prevState => ({images: []}));
//       _.map(val, (img) => {
//         console.log(img);
//         this.setState(prevState => ({images: [...prevState.images, {
//         src: img,
//         thumbnail: img,
//         thumbnailWidth: 200,
//         }]}))});
//       });
//     });
//   };
//   onSelectImage = (index, image) => {
//         var images = this.state.images.slice();
//         var img = images[index];
//         if(img.hasOwnProperty("isSelected"))
//             img.isSelected = !img.isSelected;
//         else
//             img.isSelected = true;
//
//         this.setState({
//             images: images
//         });
//     }
//   onSaveImages = () => {
//     const { editorState, onChange } = this.props;
//
//      _.map(this.state.images, img => {
//       if(img.isSelected){
//         this.setState(prevState => ({selectedImages: [...prevState.selectedImages, img.src]}), () => onChange(AtomicBlockUtils.insertAtomicBlock(editorState, Entity.create('image', 'IMMUTABLE', {src: img.src}), ' ')));
//       }
//      });
//
//       if ($("#myModal").is(":visible")) {
//           $(".modal-close").trigger('click');
//       }
//     }
//   render() {
//     return (
//       <div>
//       <div onClick={this.addImage} data-toggle="modal" data-target="#myModal">⭐</div>
//       <div id="myModal" className="modal fade" ref="dialog">
//         <div className="modal-dialog">
//           <div className="modal-content">
//             <div className="modal-header">
//               <button type="button" className="close modal-close" data-dismiss="modal">&times;</button>
//               <h4 className="modal-title">Select Images</h4>
//             </div>
//             <div className="modal-body">
//               <Gallery images={this.state.images}  onSelectImage={this.onSelectImage} />
//             </div>
//             <div className="modal-footer">
//               <button type="button" className="btn btn-default" onClick={this.onSaveImages}>Add</button>
//             </div>
//           </div>
//         </div>
//       </div>
//       </div>
//     );
//   }
// }
//
// class CreateStatic extends Component {
//   state = { 
//     content: EditorState.createEmpty(),
//   };
//
//   static propTypes = {
//      type: PropTypes.string.isRequired,
//      template: PropTypes.string.isRequired
//    };
//  constructor(props) {
//     super(props);
//     this.onSaveStatic = this.onSaveStatic.bind(this);
//   }
//
//   onEditorStateChange = (editorState) => {
//     this.setState(prevState => ({ content: editorState}));
//   }
//
//   onSaveStatic = () => {
//     console.log(convertToRaw(this.state.content.getCurrentContent()));
//     console.log(stateToHTML(this.state.content.getCurrentContent()));
//     // var content = stateToHTML(this.state.content.getCurrentContent());
//     var content = convertToRaw(this.state.content.getCurrentContent());
//     // console.log(draftToHtml(convertToRaw(this.state.content.getCurrentContent())));
//    // var content = draftToHtml(convertToRaw(this.state.content.getCurrentContent()));
//     fetch('http://local.inkskill.com/wordpress/wp-json/email-builder/v1/static', {
//       method: 'POST',
//       headers: {
//         'Accept': 'application/json',
//         'Content-Type': 'application/json',
//       },
//       body: JSON.stringify({
//        template: this.props.template,
//        type: this.props.type,
//        content: JSON.stringify(content)
//       })
//     }).then(result => {
//       result.json().then(val => {
//         const editorState = EditorState.push(this.state.content, ContentState.createFromText(' '));
//         this.onEditorStateChange(editorState);
//         // $('#slider').toggleClass('open');
//       });
//     });
//   }
//   mediaBlockRenderer = (block) => {
//           if (block.getType() === 'atomic') {
//                   return {
//                           component: this.Media,
//                           editable: false
//                   };
//           }
//           return null;
//   }
//
//   Image = (props) => {
//           return <img src={props.src} />;
//   };
//
//   Media = (props) => {
//
//           const entity = Entity.get(props.block.getEntityAt(0));
//
//           const {src} = entity.getData();
//           const type = entity.getType();
//
//           let media;
//           if (type === 'image') {
//                   media = <this.Image src={src} />;
//           }
//
//           return media;
//   };
//   render() {
//     return (
//         <div id="slider" className="transition">
//          <div className="editor" style={{background: '#fff'}}>
//           <Editor onEditorStateChange={this.onEditorStateChange}  blockRendererFn={this.mediaBlockRenderer} toolbarCustomButtons={[<ImageImportOption onChange={this.onEditorStateChange} editorState={this.state.content} />]} />
//          </div>
//          <div className="col-sm-12 text-center">
//            <button type="button" className="btn btn-primary" onClick={this.onSaveStatic}>Save</button>
//            <button type="button" className="btn btn-primary offscreen">Close</button>
//          </div>
//       </div>
//     );
//   }
// }
//
// export default CreateStatic;
