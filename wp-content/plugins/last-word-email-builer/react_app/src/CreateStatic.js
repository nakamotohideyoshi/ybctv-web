import React, { Component } from 'react';
import TinyMCE from 'react-tinymce';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import $ from 'jquery';
import _ from 'lodash';
import Gallery from 'react-grid-gallery';
import Config from './Config';
import Guid from 'guid';

class HTMLModal extends Component {
state = { 
  content: '',
};
propTypes ={
    handleHideHtmlModal: React.PropTypes.func.isRequired,
    onSaveHtml: React.PropTypes.func.isRequired,
}
onSaveHtml = () => {
  const { editorState, onChange } = this.props;

    this.setState(prevState => ({content: [...prevState.content, this.state.content]}), () =>  {
      this.props.onSaveHtml(this.state.content)
      if ($("#myHtmlModal").is(":visible")) {
          $(".modal-close").trigger('click');
      }
    });
  }
  componentDidMount = () => {
    $(ReactDOM.findDOMNode(this.refs.myHtmlModal)).trigger('click');
  }

  onChange = (event) => {
    event.preventDefault();
    //console.dir(event.target.value);
    var val = event.target.value;
    //this.setState(prevState => ({content: val.replace(/<img[^>]*>/g,"$1 data-width='200'")}));
     this.setState(prevState => ({content: val}));
  }

  handleHideModal = () => {
   this.props.handleHideModal();
  }

  render(){
      return (
        <div>
        <button data-toggle="modal" data-target="#myHtmlModal" ref="myHtmlModal"></button>
        <div id="myHtmlModal"  className="modal fade" ref="dialog">
          <div className="modal-dialog">
            <div className="modal-content" style={{width: '800px'}}>
              <div className="modal-header">
                <button type="button" className="close modal-close" data-dismiss="modal" onClick={this.handleHideModal}>&times;</button>
                <h4 className="modal-title">Add HTML</h4>
              </div>
              <div className="modal-body" style={{height: '450px', overflow: 'hidden'}}>
              <form className="form-horizontal">
                <div className="form-group">
                  <div className="col-sm-12">
                    <textarea rows="20" cols="10" className="form-control" id="content" name="content" placeholder="HTML" onChange={this.onChange}/>
                  </div>
                </div>
              </form>
              </div>
              <div className="modal-footer">
                <button type="button" className="btn btn-default" onClick={this.onSaveHtml}>Add</button>
              </div>
            </div>
          </div>
        </div>
        </div>
      )
  }
};
  class Modal extends Component {
  state = { 
    images: [],
    selectedImages: [],
    imagePage: 1,
    totoalImages: 0
  };
  propTypes ={
      handleHideModal: React.PropTypes.func.isRequired,
      onSaveImages: React.PropTypes.func.isRequired,
      site: React.PropTypes.string.isRequired
  }
  onSelectImage = (index, image) => {
        var images = this.state.images.slice();
        var img = images[index];
        console.log(img);
        if(img.hasOwnProperty("isSelected")){
          img.isSelected = !img.isSelected;
          this.setState({selectedImages: this.state.selectedImages.filter((sel) => {
                  return sel !== img.src;
              })});
        }
        else {
          img.isSelected = true;
          this.setState(prevState => ({ selectedImages: [...prevState.selectedImages, img.src]}));
        }

        // this.setState({
        //     images: images
        // });
    }
  onSaveImages = () => {
    this.props.onSaveImages(this.state.selectedImages);
    }

    onNextImagePage = () => {
     this.setState(prevState => ({ imagePage : prevState.imagePage + 1}), () => {
      this.getImages();
     });
    }

    onPrevImagePage = () => {
     this.setState(prevState => ({ imagePage : prevState.imagePage - 1}), () => {
      this.getImages();
     });
    }

    componentDidMount = () => {
      $(ReactDOM.findDOMNode(this.refs.myModal)).trigger('click');
      console.dir(this);
      this.getImages();
    }

    getImages = () => {
      fetch(Config.BASE_URL + '/wp-json/email-builder/v1/images?prefix='+ this.props.site + '&page='+ this.state.imagePage +'&cache='+ Guid.raw(), {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        }
      }).then(result => {
        result.json().then(val => {
            this.setState(prevState => ({images: [], totalImages: val[1]}));
          _.map(val[0], (img) => {
            if ( typeof img == "string" )
            {
              img = { 'guid': img.replace('http', 'https') };
            }

            this.setState(prevState => ({images: [...prevState.images, {
              src: img.guid,
              thumbnail: img.guid,
              thumbnailWidth: 200
            }]}))});
            $('.modal-backdrop').hide();
            $('body').removeClass('modal-open');
          });
        });
    }

    handleHideModal = () => {
     this.props.handleHideModal();
    }

    onKeyUp = (event) => {
     let searchFor = event.target.value;
     if(this.timeout) clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
          fetch(Config.BASE_URL + '/wp-json/email-builder/v1/searchimages?search='+ searchFor + '&cache='+ Guid.raw() + '&prefix='+ this.props.site, {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            }
          }).then(result => {
           result.json().then(val => {
            console.dir(val);
            this.setState(prevState => ({images: []}));
          _.map(val, (img) => {
            this.setState(prevState => ({images: [...prevState.images, {
            src: img.guid,
            thumbnail: img.guid,
            thumbnailWidth: 200,
            }]}))});
           });
          });
      }, 300);
    }
    render(){
        return (
          <div>
          <button data-toggle="modal" data-target="#myModal" ref="myModal"></button>

          <style dangerouslySetInnerHTML={{__html: `
            .tile { height: 100px; width: 100px; margin: 0 3px 3px 0; border: 1px solid #555; }
            .tile .tile-viewport { line-height: 100px; text-align: center; height: 100px !important; }
            .tile .tile-viewport img { vertical-align: middle; max-width: 100%; max-height: 100%; width: auto !important; height: auto !important; }
          `}} />

          <div id="myModal"  className="modal fade" ref="dialog">
            <div className="modal-dialog">
              <div className="modal-content" style={{width: '800px'}}>
                <div className="modal-header">
                  <button type="button" className="close modal-close" data-dismiss="modal" onClick={this.handleHideModal}>&times;</button>
                  <h4 className="modal-title">Select Images</h4>
                </div>
                <div className="modal-body" style={{height: '600px', overflow: 'scroll'}}>
                 <div style={{width: '400px', float: 'left', overflow: 'hidden'}}>
                   <Gallery images={this.state.images}  onSelectImage={this.onSelectImage}/>
                    <ul className="pager">
                      <li>{this.state.imagePage > 1 ? <a href="#" onClick={this.onPrevImagePage}>Previous</a> : ''}</li>
                      <li>{this.state.imagePage < Math.ceil(this.state.totalImages / 5) ? <a href="#" onClick={this.onNextImagePage}>Next</a> : ''}</li>
                    </ul>
                 </div>
                 <div style={{width: '300px', float: 'right'}}>
                <form className="form-horizontal">
                  <div className="form-group">
                    <div className="col-sm-12">
                      <label htmlFor="article" className="control-label">Search by Image Name</label>
                      <input type="text" className="form-control" id="article" placeholder="Image Name" onChange={this.onKeyUp}/>
                    </div>
                  </div>
                </form>
                 </div>
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-default" onClick={this.onSaveImages}>Add</button>
                </div>
              </div>
            </div>
          </div>
          </div>
        )
    }
};
class CreateStatic extends Component {
  state = { 
    content: '',
    showModal: false,
    showHtmlModal: false
  };

  static propTypes = {
     type: PropTypes.string.isRequired,
     template: PropTypes.string.isRequired,
     showStatic: PropTypes.bool.isRequired,
   };
 constructor(props) {
    super(props);
 }

  onChange = (value) => {
    if(this.props.type === 'Newsletter_Subscribe'){
      this.setState(prevState => ({content: value.level.content.replace(/(<img.*src="([^"]*)"[^>]*)>/ig,'$1 data-width=\"200">')}));
    }
    else{
      this.setState(prevState => ({ content: value.level.content}));
    }
  }

  onCloseStatic = () => {
    this.setState(prevState => ({content: ''}));
    $('#slider').toggleClass('open');
    this.props.onCloseStatic();
  }


  onSaveStatic = () => {
    console.dir(this);
    this.setState(prevState => ({ 
      content: prevState.content.replace(/<p><br data-mce-bogus="1"><\/p>/g,"")
    }), () => {
      if(this.state.content.length > 1){
        console.log(this.state.content);
        fetch(Config.BASE_URL + '/wp-json/email-builder/v1/static', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
           template: this.props.template,
           type: this.props.type,
           content: this.state.content,
           prefix: this.props.site
          })
        }).then(result => {
          result.json().then(val => {
            this.setState(prevState => ({content: ''}));
            $('#slider').toggleClass('open');
            this.props.onCloseStatic();
          });
        });
      }
      else{
        fetch(Config.BASE_URL + '/wp-json/email-builder/v1/removestatic', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
           template: this.props.template,
           type: this.props.type,
           prefix: this.props.site
          })
        }).then(result => {
          result.json().then(val => {
            this.setState(prevState => ({content: ''}));
            $('#slider').toggleClass('open');
            this.props.onCloseStatic();
          });
        });
      }
    });
  }

    handleHideModal = () => {
        this.setState(prevState => ({showModal: false}))
    }
    handleHideHtmlModal = () => {
        this.setState(prevState => ({showHtmlModal: false}))
    }
    handleShowModal = () => {
        this.setState(prevState => ({showModal: true}))
    }
    handleHtmlModal = () => {
        this.setState(prevState => ({showHtmlModal: true}))
    }
    onSaveImages = (images) => {
      console.log(images);
      console.log(this.state);
      $(".modal-backdrop").hide();
      if(this.state.content.length > 0 && this.state.content.indexOf('<img') >= 0){
        if(this.props.type === 'Newsletter_Subscribe'){
          this.setState(prevState => ({content: prevState.content.replace(/<img[^>]*>/g,"<img data-width='200' src='"+ images[0] + "'/>"), showModal: false}));
        }
        else{
          this.setState(prevState => ({content: prevState.content.replace(/<img[^>]*>/g,"<img src='"+ images[0] + "'/>"), showModal: false}));
        }
      }
      else{
        if(this.props.type === 'Top_Leaderboard'){
          let content = '<table class="device_innerblock" width="728" align="center">\
                          <tbody>\
                           <tr>\
                            <td style="padding: 10px 10px 10px 10px;" align="center">\
                              <a style="vertical-align: bottom; max-width: 100%;" href="">\
                                <img src="'+ images[0] +'" alt="" />\
                              </a>\
                             </td>\
                           </tr>\
                          </tbody>\
                         </table>';
          this.setState(prevState => ({content: content, showModal: false}));
        }
        else if(this.props.type === 'Footer_Leaderboard'){
          let content = '<table class="device_innerblock" width="728" align="center">\
                          <tbody>\
                           <tr>\
                             <td style="padding: 10px 10px 10px 10px;" align="center">\
                              <a href="/">\
                               <img src="'+ images[0] +'" alt="" />\
                              </a>\
                             </td>\
                           </tr>\
                          </tbody>\
                         </table>';
          this.setState(prevState => ({content: content, showModal: false}));
        }
        else{
          this.setState(prevState => ({content: "<img src='"+ images[0] + "'/>", showModal: false}));
        }
      }
    }
    onSaveHtml = (html) => {
      console.log(html[html.length - 1]);
      this.setState(prevState => ({content: html[html.length - 1], showHtmlModal: false}));
    }

    componentDidMount = () => {
      var type = this.props.type;

      fetch(Config.BASE_URL  + '/wp-json/email-builder/v1/static?type='+ type + '&template='+ this.props.template + '&cache='+ Guid.raw() + '&prefix='+ this.props.site, {
       method: 'GET',
       headers: {
         'Accept': 'application/json',
         'Content-Type': 'application/json',
       }
     }).then(result => {
       result.json().then(val => {
         if(val !== null){
          console.dir(val);
         this.setState(prevState => ({ content: val.Content}));
         }
       });
     });
    }

    componentWillReceiveProps = (nextProps) => {
     this.setState(prevState => ({content: ''}));

     var type = nextProps.type;

    fetch(Config.BASE_URL + '/wp-json/email-builder/v1/static?type='+ nextProps.type + '&template='+ nextProps.template + '&cache='+ Guid.raw() + '&prefix='+ this.props.site, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    }).then(result => {
      result.json().then(val => {
          if(val !== null)
          {
            this.setState(prevState => ({ 
              content: val.Content
            }));

            $('.slider-loader').css('display', 'none');
          }
      });
    });
    }

  render() {
    return (
        <div id="slider" className="transition">
          <img 
            className="slider-loader1"
            src="https://pa.cms-lastwordmedia.com//wp-content/plugins/email-builder/loading.gif" 
            style={{ 
              'position': 'fixed', 
              'zIndex': '50000', 
              'left': '50%', 
              'top': '50%', 
              'marginLeft': '-128px', 
              'marginTop': '-128px',
              'display': 'none'
            }} 
          />
         <div className="editor" style={{background: '#fff'}}>
           <div className="text-editor">
  <TinyMCE
        content={this.state.content}
        key={this.state.content}
        config={{
          height: 500,
          toolbar: 'undo redo | bold italic | alignleft aligncenter alignright',
          plugins: [
            'advlist autolink lists link contextmenu image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
          ]
        }}
        onChange={this.onChange}
      />
        </div>
         </div>
         <div className="row text-center" style={{background: '#fff', padding: '10px', width: '100%'}}>
          <div className="col-sm-4">
            <button type="button" className="btn btn-primary" onClick={this.handleShowModal}>Import Images</button>
          </div>
          <div className="col-sm-4">
          <button type="button" className="btn btn-primary" onClick={this.onSaveStatic}>Save</button>
          </div>
          <div className="col-sm-4">
          <button type="button" className="btn btn-primary offscreen" onClick={this.onCloseStatic}>Close</button>
          </div>
         </div>
          {this.state.showModal ? <Modal handleHideModal={this.handleHideModal} onSaveImages={this.onSaveImages} site={this.props.site}/> : null}
          {this.state.showHtmlModal ? <HTMLModal handleHideModal={this.handleHideHtmlModal} onSaveHtml={this.onSaveHtml}/> : null}
      </div>
    );
  }
}

export default CreateStatic;
