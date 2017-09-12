//
// import React, { Component } from 'react';
// import DragArticle from './DragArticle';
//
// class ArticleList extends Component {
//   state = { };
//
//   onChangePage = (event) => {
//     event.preventDefault();
//     this.props.onChangePage(event.target.name);
//   }
//
//   render() {
//     return (
//       <div>
//       {this.props.articles.map((article, key) => {
//        return <DragArticle name={article.post_title} desc={article.post_excerpt} id={article.ID} onArticleDropped={this.props.onArticleDropped} isDisabled={article.isDisabled} key={key}/>
//       })}
//       </div>
//     );
//   }
// }
//
// export default ArticleList;
