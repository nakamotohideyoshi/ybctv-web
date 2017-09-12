// import React, { Component } from 'react';
// import PropTypes from 'prop-types';
// import Config from './Config';
//
// class Dashboard extends Component {
//   state = {
//     offset: 0,
//     page: 1,
//   };
//
//   static propTypes = {
//      getEmails: PropTypes.func.isRequired,
//      onChangePage: PropTypes.func.isRequired
//    };
//
//   constructor(props) {
//      super(props);
//   }
//
//   componentDidMount = () => {
//     this.props.getEmails(this.state.offset);
//   }
//
//
//   editEmail = (event) => {
//    event.preventDefault();
//    this.props.onChangePage('CreateEmail', event.target.id);
//   }
//
//
//   livePreview = (event) => {
//    event.preventDefault();
//    // this.props.onChangePage('PreviewEmail', event.target.id);
//    window.open('https://pa.cms-lastwordmedia.com/email-approve?emailId='+ event.target.id);
//   }
//
//   onNextPage = () => {
//     this.setState(prevState => ({
//       page: prevState.page + 1,
//       offset: prevState.offset + 5
//     }), () => this.props.getEmails(this.state.offset));
//   }
//
//   onPreviousPage = () => {
//     this.setState(prevState => ({
//       page: prevState.page - 1,
//       offset: prevState.offset - 5
//     }), () => this.props.getEmails(this.state.offset));
//   }
//
//   render() {
//     return (
//    <div className="container">
//       <div className="row">
//         <div className="col-xs-12">
//           <h1>Newsletters</h1>
//         </div>
//       </div>
//         <div className="row">
//           <div className="col-xs-12">
//             <table className="table">
//               <thead>
//                 <tr>
//                   <th>Email Name</th>
//                   <th>Status</th>
//                   <th>Edit</th>
//                 </tr>
//               </thead>
//               <tbody>
//               {this.props.emails.map((email, key) => {
//                 return <tr key={key}>
//                   <td>{email.EmailName}</td>
//                   <td>{email.SendToAdestraOn}</td>
//                   <td><button type="button" disabled={email.SendToAdestraOn !== null}  id={email.EmailId} onClick={this.editEmail} className="btn btn-primary">Edit</button></td>
//                   <td><button type="button" disabled={email.SendToAdestraOn !== null}  id={email.EmailId} onClick={this.livePreview} className="btn btn-primary">Live Preview</button></td>
//                 </tr>
//                 })}
//               </tbody>
//             </table>
//           </div>
//         </div>
//       <div className="row">
//         <div className="col-xs-12">
//           <ul className="pager">
//             <li className="previous dis">{this.state.page > 1 ? <a href="#" onClick={this.onPreviousPage}>Previous</a> : ''}</li>
//             <li className="next">{this.state.page < Math.ceil(this.props.totalEmails / 5) ? <a href="#" onClick={this.onNextPage}>Next</a> : ''}</li>
//           </ul>
//         </div>
//       </div>
//     </div>
//     );
//   }
// }
//
// export default Dashboard;
