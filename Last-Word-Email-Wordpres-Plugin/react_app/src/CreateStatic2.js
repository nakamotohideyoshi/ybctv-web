// import React, { Component } from 'react';
// import ReactQuill, {Quill} from 'react-quill';
// import ReactDOM from 'react-dom';
// import PropTypes from 'prop-types';
// import $ from 'jquery';
// import _ from 'lodash';
// import Gallery from 'react-grid-gallery';
// import theme from 'react-quill/dist/quill.snow.css';
// import Config from './Config';
// import Guid from 'guid';
//
// class HTMLModal extends Component {
// state = { 
//   content: '',
// };
// propTypes ={
//     handleHideHtmlModal: React.PropTypes.func.isRequired,
//     onSaveHtml: React.PropTypes.func.isRequired,
// }
// onSaveHtml = () => {
//   const { editorState, onChange } = this.props;
//
//     this.setState(prevState => ({content: [...prevState.content, this.state.content]}), () =>  {
//       console.log(this.state.content);
//       this.props.onSaveHtml(this.state.content)
//       if ($("#myHtmlModal").is(":visible")) {
//           $(".modal-close").trigger('click');
//       }
//     });
//   }
//   componentDidMount = () => {
//     $(ReactDOM.findDOMNode(this.refs.myHtmlModal)).trigger('click');
//   }
//
//   onChange = (event) => {
//     event.preventDefault();
//     //console.dir(event.target.value);
//     var val = event.target.value;
//     this.setState(prevState => ({content: val}));
//   }
//
//   handleHideModal = () => {
//    this.props.handleHideModal();
//   }
//
//   render(){
//       return (
//         <div>
//         <button data-toggle="modal" data-target="#myHtmlModal" ref="myHtmlModal"></button>
//         <div id="myHtmlModal"  className="modal fade" ref="dialog">
//           <div className="modal-dialog">
//             <div className="modal-content" style={{width: '800px'}}>
//               <div className="modal-header">
//                 <button type="button" className="close modal-close" data-dismiss="modal" onClick={this.handleHideModal}>&times;</button>
//                 <h4 className="modal-title">Add HTML</h4>
//               </div>
//               <div className="modal-body" style={{height: '450px', overflow: 'hidden'}}>
//               <form className="form-horizontal">
//                 <div className="form-group">
//                   <div className="col-sm-12">
//                     <textarea rows="20" cols="10" className="form-control" id="content" name="content" placeholder="HTML" onChange={this.onChange}/>
//                   </div>
//                 </div>
//               </form>
//               </div>
//               <div className="modal-footer">
//                 <button type="button" className="btn btn-default" onClick={this.onSaveHtml}>Add</button>
//               </div>
//             </div>
//           </div>
//         </div>
//         </div>
//       )
//   }
// };
//   class Modal extends Component {
//   state = { 
//     images: [],
//     selectedImages: []
//   };
//   propTypes ={
//       handleHideModal: React.PropTypes.func.isRequired,
//       onSaveImages: React.PropTypes.func.isRequired,
//   }
//   onSelectImage = (index, image) => {
//         var images = this.state.images.slice();
//         var img = images[index];
//         console.log(img);
//         if(img.hasOwnProperty("isSelected")){
//           img.isSelected = !img.isSelected;
//           this.setState({selectedImages: this.state.selectedImages.filter((sel) => {
//                   return sel !== img.src;
//               })});
//         }
//         else {
//           img.isSelected = true;
//           this.setState(prevState => ({ selectedImages: [...prevState.selectedImages, img.src]}));
//         }
//
//         // this.setState({
//         //     images: images
//         // });
//     }
//   onSaveImages = () => {
//     this.props.onSaveImages(this.state.selectedImages);
//     }
//     componentDidMount = () => {
//       $(ReactDOM.findDOMNode(this.refs.myModal)).trigger('click');
//       fetch(Config.BASE_URL + '/wp-json/email-builder/v1/images?cache='+ Guid.raw(), {
//         method: 'GET',
//         headers: {
//           'Accept': 'application/json',
//           'Content-Type': 'application/json',
//         }
//       }).then(result => {
//         result.json().then(val => {
//           console.dir(val);
//           this.setState(prevState => ({images: []}));
//         _.map(val, (img) => {
//           this.setState(prevState => ({images: [...prevState.images, {
//           src: img.guid,
//           thumbnail: img.guid,
//           thumbnailWidth: 200,
//           }]}))});
//         });
//       });
//     }
//
//     handleHideModal = () => {
//      this.props.handleHideModal();
//     }
//
//     onKeyUp = (event) => {
//      let searchFor = event.target.value;
//      if(this.timeout) clearTimeout(this.timeout);
//       this.timeout = setTimeout(() => {
//           fetch(Config.BASE_URL + '/wp-json/email-builder/v1/searchimages?search='+ searchFor + '&cache='+ Guid.raw(), {
//             method: 'GET',
//             headers: {
//               'Accept': 'application/json',
//               'Content-Type': 'application/json',
//             }
//           }).then(result => {
//            result.json().then(val => {
//             console.dir(val);
//             this.setState(prevState => ({images: []}));
//           _.map(val, (img) => {
//             this.setState(prevState => ({images: [...prevState.images, {
//             src: img.guid,
//             thumbnail: img.guid,
//             thumbnailWidth: 200,
//             }]}))});
//            });
//           });
//       }, 300);
//     }
//     render(){
//         return (
//           <div>
//           <button data-toggle="modal" data-target="#myModal" ref="myModal"></button>
//           <div id="myModal"  className="modal fade" ref="dialog">
//             <div className="modal-dialog">
//               <div className="modal-content" style={{width: '800px'}}>
//                 <div className="modal-header">
//                   <button type="button" className="close modal-close" data-dismiss="modal" onClick={this.handleHideModal}>&times;</button>
//                   <h4 className="modal-title">Select Images</h4>
//                 </div>
//                 <div className="modal-body" style={{height: '600px', overflow: 'scroll'}}>
//                  <div style={{width: '400px', float: 'left', overflow: 'hidden'}}><Gallery images={this.state.images}  onSelectImage={this.onSelectImage}/></div>
//                  <div style={{width: '300px', float: 'right'}}>
//                 <form className="form-horizontal">
//                   <div className="form-group">
//                     <div className="col-sm-12">
//                       <label htmlFor="article" className="control-label">Image Name</label>
//                       <input type="text" className="form-control" id="article" placeholder="Image Name" onChange={this.onKeyUp}/>
//                     </div>
//                   </div>
//                 </form>
//                  </div>
//                 </div>
//                 <div className="modal-footer">
//                   <button type="button" className="btn btn-default" onClick={this.onSaveImages}>Add</button>
//                 </div>
//               </div>
//             </div>
//           </div>
//           </div>
//         )
//     }
// };
// class CreateStatic extends Component {
//   state = { 
//     content: '',
//     showModal: false,
//     showHtmlModal: false
//   };
//
//   static propTypes = {
//      type: PropTypes.string.isRequired,
//      template: PropTypes.string.isRequired,
//      showStatic: PropTypes.bool.isRequired,
//    };
//  constructor(props) {
//     super(props);
//     this.reactQuillRef = null;
//  }
//
//   onChange = (value) => {
//     this.setState(prevState => ({ content: value}));
//   }
//
//   onCloseStatic = () => {
//     this.setState(prevState => ({content: ''}));
//     $('#slider').toggleClass('open');
//   }
//
//
//   onSaveStatic = () => {
//     if(this.reactQuillRef.getEditor().getLength() > 1){
//       console.log(this.state.content);
//       fetch(Config.BASE_URL + '/wp-json/email-builder/v1/static', {
//         method: 'POST',
//         headers: {
//           'Accept': 'application/json',
//           'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//          template: this.props.template,
//          type: this.props.type,
//          content: this.state.content
//         })
//       }).then(result => {
//         result.json().then(val => {
//           this.setState(prevState => ({content: ''}));
//           $('#slider').toggleClass('open');
//         });
//       });
//     }
//     else{
//       fetch(Config.BASE_URL + '/wp-json/email-builder/v1/removestatic', {
//         method: 'POST',
//         headers: {
//           'Accept': 'application/json',
//           'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({
//          template: this.props.template,
//          type: this.props.type
//         })
//       }).then(result => {
//         result.json().then(val => {
//           this.setState(prevState => ({content: ''}));
//           $('#slider').toggleClass('open');
//         });
//       });
//     }
//   }
//   modules = {
//  toolbar: {
//             container: "#toolbar",
//             handlers: {
//                 "insertName":  () => {
//                     // this.quill.insertText(this.quill.getSelection().index, this.state.images);                    
//                 }
//             }
//         }
//   }
//
//   formats =  [
//     'header',
//     'bold', 'italic', 'underline', 'strike', 'blockquote',
//     'list', 'bullet', 'indent',
//     'link', 'image'
//   ]
//
//
//     handleHideModal = () => {
//         this.setState(prevState => ({showModal: false}))
//     }
//     handleHideHtmlModal = () => {
//         this.setState(prevState => ({showHtmlModal: false}))
//     }
//     handleShowModal = () => {
//         this.setState(prevState => ({showModal: true}))
//     }
//     handleHtmlModal = () => {
//         this.setState(prevState => ({showHtmlModal: true}))
//     }
//     onSaveImages = (images) => {
//       $(".modal-backdrop").hide();
//       _.each(images, (img) => {
//         this.setState(prevState => ({content: prevState.content + "<img src='"+ img + "'/>", showModal: false}));
//       });
//     }
//     onSaveHtml = (html) => {
//       console.log(html[html.length - 1]);
//       this.setState(prevState => ({content: html[html.length - 1], showHtmlModal: false}));
//     }
//
//     componentDidMount = () => {
//      fetch(Config.BASE_URL  + '/wp-json/email-builder/v1/static?type='+ this.props.type + '&template='+ this.props.template + '&cache='+ Guid.raw(), {
//        method: 'GET',
//        headers: {
//          'Accept': 'application/json',
//          'Content-Type': 'application/json',
//        }
//      }).then(result => {
//        result.json().then(val => {
//          if(val !== null){
//           console.dir(val);
//          this.setState(prevState => ({ content: val.Content}));
//          }
//        });
//      });
//     }
//
//     componentWillReceiveProps = (nextProps) => {
//      this.setState(prevState => ({content: ''}));
//     fetch(Config.BASE_URL + '/wp-json/email-builder/v1/static?type='+ nextProps.type + '&template='+ nextProps.template + '&cache='+ Guid.raw(), {
//       method: 'GET',
//       headers: {
//         'Accept': 'application/json',
//         'Content-Type': 'application/json',
//       }
//     }).then(result => {
//       result.json().then(val => {
//         if(val !== null)
//         this.setState(prevState => ({ content: val.Content}));
//       });
//     });
//     }
//
//   render() {
//     return (
//         <div id="slider" className="transition">
//          <div className="editor" style={{background: '#fff'}}>
//            <div className="text-editor">
//               <div id="toolbar">
//                  <select className="ql-header">
//                     <option value="1"></option>
//                     <option value="2"></option>
//                     <option selected></option>
//                   </select>
//                   <button className="ql-indent" value="-1"></button>
//                   <button className="ql-indent" value="+1"></button>
//                   <button className="ql-bold"></button>
//                   <button className="ql-italic"></button>
//                   <select className="ql-color">
//                     <option value="red"></option>
//                     <option value="green"></option>
//                     <option value="blue"></option>
//                     <option value="orange"></option>
//                     <option value="violet"></option>
//                     <option value="#d0d1d2"></option>
//                     <option selected></option>
//                   </select>
//                   <button className="ql-link"></button>
//                   <button className="ql-insertName" onClick={this.handleShowModal}><i className="fa fa-picture-o" aria-hidden="true"></i></button>
//                   <button className="ql-insertName" onClick={this.handleHtmlModal}><i className="fa fa-code" aria-hidden="true"></i></button>
//               </div>  
//               <ReactQuill onChange={this.onChange} modules={this.modules} value={this.state.content} theme="snow" formats={this.format} ref={(el) => { this.reactQuillRef = el }}>
//               </ReactQuill>
//         </div>
//          </div>
//          <div className="col-sm-12 text-center">
//            <button type="button" className="btn btn-primary" onClick={this.onSaveStatic}>Save</button>
//            <button type="button" className="btn btn-primary offscreen" onClick={this.onCloseStatic}>Close</button>
//          </div>
//           {this.state.showModal ? <Modal handleHideModal={this.handleHideModal} onSaveImages={this.onSaveImages}/> : null}
//           {this.state.showHtmlModal ? <HTMLModal handleHideModal={this.handleHideHtmlModal} onSaveHtml={this.onSaveHtml}/> : null}
//       </div>
//     );
//   }
// }
//
// export default CreateStatic;
